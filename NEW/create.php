<?php
session_start();
// Include config file
require_once "config.php";
/*
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
*/
// Define variables and initialize with empty values
$category = $subscription = $serviceprovider = $amount = $renewaldate = $paymentportal = $remarks = "";
$category_err = $subscription_err = $serviceprovider_err =  $amount_err =  $renewaldate_err = $paymentportal_err = $remarks_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    if (empty($category_err) && empty($subscription_err) && empty($serviceprovider_err) && empty($amount_err) 
    && empty($renewaldate_err) && empty($paymentportal_err) && empty($remarks_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO userdata (category, subscription, serviceprovider, amount, renewaldate, paymentportal, remarks,userid) VALUES (?, ?, ?, ?, ?, ?, ?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssissss", $param_category, $param_subscription, $param_serviceprovider, 
            $param_amount, $param_renewaldate, $param_paymentportal, $param_remarks,$param_userid);

            // Set parameters
            $param_category = $category;
            $param_subscription = $subscription;
            $param_serviceprovider = $serviceprovider;
            $param_amount = $amount;
            $param_renewaldate = $renewaldate;
            $param_paymentportal = $paymentportal;
            $param_remarks = $remarks;
            $param_userid = $_SESSION["userid"];

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <label>Amount to Pay</label>
                            <input type="text" name="amount"
                                class="form-control <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $amount; ?>">
                            <span class="invalid-feedback">
                                <?php echo $amount_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Renewal Date</label>
                            
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" placeholder="YYYY-MM-DD" class="form-control" name="renewaldate" <?php echo
                                    (!empty($renewaldate_err)) ? 'is-invalid' : ''; ?>>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                    <span class="invalid-feedback">
                                        <?php echo $renewaldate_err; ?>
                                    </span>
                                </div>
                            </div>
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
                            <textarea name="remarks"
                                class="form-control <?php echo (!empty($remarks_err)) ? 'is-invalid' : ''; ?>">
                                <?php echo $remarks; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $remarks_err; ?>
                            </span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>