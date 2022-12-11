<?php
session_start();
// Include config file
require_once "config.php";
$x = $_SESSION["userid"];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://amount.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-1 clearfix">
                        <h3>Hi,
                            <?php echo htmlspecialchars($_SESSION["username"]); ?>!
                            <a href="logout.php" class="btn btn-warning pull-right"><i class="fa fa-plus">
                                </i> Logout</a>
                        </h3>
                    </div>
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Subscription Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add
                            Subscription Tracker</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <?php
        $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "category";
        $order = !empty($_GET["order"]) ? $_GET["order"] : "asc";
        $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "category";


        $sql = "SELECT * FROM userdata WHERE userid='$x' ORDER BY " . $orderBy . " " . $order;

        $result = $mysqli->query($sql);

        $categoryOrder = "asc";
        $serviceproviderOrder = "asc";
        $subscriptionOrder = "asc";
        $amountOrder = "asc";
        $renewaldateOrder = "asc";
        $paymentportalOrder = "asc";
        $remarksOrder = "asc";

        if ($orderBy == "category" && $order == "asc") {
            $categoryOrder = "desc";
        }
        if ($orderBy == "subscription" && $order == "asc") {
            $amountOrder = "desc";
        }
        if ($orderBy == "serviceprovider" && $order == "asc") {
            $categoryOrder = "desc";
        }
        if ($orderBy == "amount" && $order == "asc") {
            $amountOrder = "desc";
        }
        if ($orderBy == "renewaldate" && $order == "asc") {
            $categoryOrder = "desc";
        }
        if ($orderBy == "paymentportal" && $order == "asc") {
            $amountOrder = "desc";
        }
        if ($orderBy == "remarks" && $order == "asc") {
            $amountOrder = "desc";
        }

        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><a href="?orderby=category&order=<?php echo $categoryOrder; ?>">Category</a></th>
                    <th><a href="?orderby=subscription&order=<?php echo $subscriptionOrder; ?>">Subscription</a></th>
                    <th><a href="?orderby=category&order=<?php echo $serviceproviderOrder; ?>">Service Provider</a></th>
                    <th><a href="?orderby=amount&order=<?php echo $amountOrder; ?>">Amount</a></th>
                    <th><a href="?orderby=category&order=<?php echo $renewaldateOrder; ?>">Renewal Date</a></th>
                    <th><a href="?orderby=category&order=<?php echo $paymentportalOrder; ?>">Payment Portal</a></th>
                    <th><a href="?orderby=category&order=<?php echo $remarksOrder; ?>">Remarks</a></th>
                    <th>Actions</th>

                    
                </tr>
            </thead>
            <tbody>

                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['id']; ?>
                    </td>
                    <td>
                        <?php echo $row['category']; ?>
                    </td>
                    <td>
                        <?php echo $row['subscription']; ?>
                    </td>
                    <td>
                        <?php echo $row['serviceprovider']; ?>
                    </td>
                    <td>
                        <?php echo $row['amount']; ?>
                    </td>
                    <td>
                        <?php echo $row['renewaldate']; ?>
                    </td>
                    <td>
                        <?php echo $row['paymentportal']; ?>
                    </td>
                    <td>
                        <?php echo $row['remarks']; ?>
                    </td>
                    <td>
                    <?php
                        echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                        echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                    ?>

                    </td>

                </tr>
                <?php
            }?>
            </tbody>
        </table>

    </div>




    <div class="container-md">
        <?php

        // Attempt select query execution
        $sql = "SELECT * FROM userdata WHERE userid='$x'";
        if ($result = $mysqli->query($sql)) {
            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Category</th>";
                echo "<th>Subscription Name</th>";
                echo "<th>Service Provider</th>";
                echo "<th><a href='sort.php?sort=amount'>Amount</a></th>";
                echo "<th>Renewal Date</th>";
                echo "<th>Payment Portal</th>";
                echo "<th>Remarks</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_array()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['subscription'] . "</td>";
                    echo "<td>" . $row['serviceprovider'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['renewaldate'] . "</td>";
                    echo "<td>" . $row['paymentportal'] . "</td>";
                    echo "<td>" . $row['remarks'] . "</td>";
                    echo "<td>";
                    echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                    echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                // Free result set
                $result->free();
            } else {
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close connection
        $mysqli->close();
        ?>

    </div>

</body>

</html>