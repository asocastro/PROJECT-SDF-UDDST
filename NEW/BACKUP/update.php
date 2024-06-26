<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$category = $subscription = $serviceprovider = $amount = $renewaldate = $paymentportal = $remarks = "";
$category_err = $subscription_err = $serviceprovider_err = $amount_err = $renewaldate_err = $paymentportal_err = $remarks_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate category
    $input_category = trim($_POST["category"]);
    if (empty($input_category)) {
        $category_err = "Please enter a category.";
    } elseif (!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $category_err = "Please enter a valid category.";
    } else {
        $category = $input_category;
    }

    // Validate subscription
    $input_subscription = trim($_POST["subscription"]);
    if (empty($input_subscription)) {
        $subscription_err = "Please enter a subscription.";
    } else {
        $subscription = $input_subscription;
    }

    // Validate serviceprovider
    $input_serviceprovider = trim($_POST["serviceprovider"]);
    if (empty($input_serviceprovider)) {
        $serviceprovider_err = "Please enter a serviceprovider.";
    } else {
        $serviceprovider = $input_serviceprovider;
    }

    // Validate amount
    $input_amount = trim($_POST["amount"]);
    if (empty($input_amount)) {
        $amount_err = "Please enter the amount payable.";
    } elseif (!ctype_digit($input_amount)) {
        $amount_err = "Please enter a positive integer value.";
    } else {
        $amount = $input_amount;
    }

    // Validate renewaldate
    $input_renewaldate = trim($_POST["renewaldate"]);
    if (empty($input_renewaldate)) {
        $renewaldate_err = "Please enter a renewal date.";
    } else {
        $renewaldate = $input_renewaldate;
    }

    // Validate paymentportal
    $input_paymentportal = trim($_POST["paymentportal"]);
    if (empty($input_paymentportal)) {
        $paymentportal_err = "Please enter a payment method.";
    } else {
        $paymentportal = $input_paymentportal;
    }

    // Validate remarks
    $input_remarks = trim($_POST["remarks"]);
    if (empty($input_remarks)) {
        $remarks_err = "Enter your remarks if there's any.";
    } else {
        $remarks = $input_remarks;
    }

    // Check input errors before inserting in database
    if (
        empty($category_err) && empty($subscription_err) && empty($serviceprovider_err) && empty($amount_err)
        && empty($renewaldate_err) && empty($paymentportal_err) && empty($remarks_err)
    ) {
        // Prepare an insert statement
        $sql = "UPDATE userdata SET category=?, subscription=?, 
        serviceprovider=?, amount=?, renewaldate=?, paymentportal=?, remarks=? WHERE id=?";
        //$sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
        /*
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_name, $param_address, $param_salary, $param_id);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }*/
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "sssisssi", $param_category, $param_subscription, $param_serviceprovider, $param_amount,
                $param_renewaldate, $param_paymentportal, $param_remarks, $param_id);

            // Set parameters
            $param_category = $category;
            $param_subscription = $subscription;
            $param_serviceprovider = $serviceprovider;
            $param_amount = $amount;
            $param_renewaldate = $renewaldate;
            $param_paymentportal = $paymentportal;
            $param_remarks = $remarks;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: dashboard.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM userdata WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $category = $row["category"];
                    $subscription = $row["subscription"];
                    $serviceprovider = $row["serviceprovider"];
                    $amount = $row["amount"];
                    $renewaldate = $row["renewaldate"];
                    $paymentportal = $row["paymentportal"];
                    $remarks = $row["remarks"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();

        // Close connection
        $mysqli->close();
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category"
                                class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $category; ?>">
                            <span class="invalid-feedback">
                                <?php echo $category_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Subscription</label>
                            <input type="text" name="subscription"
                                class="form-control <?php echo (!empty($subscription_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $subscription; ?>">
                            <span class="invalid-feedback">
                                <?php echo $subscription_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Service Provider</label>
                            <input type="text" name="serviceprovider"
                                class="form-control <?php echo (!empty($serviceprovider_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $serviceprovider; ?>">
                            <span class="invalid-feedback">
                                <?php echo $serviceprovider_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount"
                                class="form-control <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $amount; ?>">
                            <span class="invalid-feedback">
                                <?php echo $amount_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Renewal Date</label>
                            <input type="text" name="renewaldate"
                                class="form-control <?php echo (!empty($renewaldate_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $renewaldate; ?>">
                            <span class="invalid-feedback">
                                <?php echo $renewaldate_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Payment Portal</label>
                            <input type="text" name="paymentportal"
                                class="form-control <?php echo (!empty($paymentportal_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $paymentportal; ?>">
                            <span class="invalid-feedback">
                                <?php echo $paymentportal_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" name="remarks"
                                class="form-control <?php echo (!empty($remarks_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $remarks; ?>">
                            <span class="invalid-feedback">
                                <?php echo $remarks; ?>
                            </span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>