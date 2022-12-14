<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM userdata WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

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
                // URL doesn't contain valid id parameter. Redirect to error page
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <style>
        body {
            background: #Fbf3e4 !important;
            font-family: 'Muli', sans-serif;
        }

        h1 {
            color: #004d8f;
            padding-top: 3rem;
            padding-bottom: 1rem;
            font-weight: bold;
        }

        h2 {
            
            color: #004d8f;
        }

        a {
            color: #004d8f;
        }
        label{
            color: #004d8f;
            font-weight: bold;
        }
        p {
            color: #000;

        }

        a:hover {
            color: #004d8f;
            text-decoration: none;
            text-shadow: 0 0 5px #004d8f50;
        }

        .form-control:focus {
            color: #000;
            background-color: #fff;
            border: 2px solid #004d8f;
            outline: 0;
            box-shadow: none;
        }

        .btn {
            background: #004d8f;
            border: #004d8f;
            
        }

        .btn:hover {
            background: #004d8f;
            border: #004d8f;
        }

        tr {
            background: #FFFFFF;
        }</style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Category</label>
                        <p><b><?php echo $row["category"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Subscription</label>
                        <p><b><?php echo $row["subscription"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Service Provider</label>
                        <p><b><?php echo $row["serviceprovider"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <p><b><?php echo $row["amount"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Renewal Date</label>
                        <p><b><?php echo $row["renewaldate"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Payment Portal</label>
                        <p><b><?php echo $row["paymentportal"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <p><b><?php echo $row["remarks"]; ?></b></p>
                    </div>
                    <p><a href="dashboard.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>