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
    <style>
        body {
            background: #Fbf3e4 !important;
            font-family: 'Muli', sans-serif;
        }

        h1 {
            color: #004d8f;
            padding-top: 3rem;
            padding-bottom: 2rem;
            font-weight: bold;
        }

        h2 {
            
            color: #000;
        }

        a {
            color: #004d8f;
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
        }
    </style>
</head>

<body>

    <div class="wrapper">
        
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-5 mb-1 ">
                                <h2 style="font-weight: bold;">Hi,
                                    <?php echo htmlspecialchars($_SESSION["username"]); ?>!
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-5 mb-1 ">
                                <a href="logout.php" class="btn btn-success pull-right" style="color=#FFFFFF">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> LOGOUT</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 mb-2 clearfix">
                        <h3 class="pull-left">Subscription Details</h3>
                        <a href="create.php" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> TRACKER</a>
                    </div>
                </div>
            </div>
        
    </div>


    <div class="container">
        <?php
        //$orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"]:"category";
        if (!empty($_GET["orderby"]) == "category") {
            $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "category";
        } else if (!empty($_GET["orderby"]) == "amount") {
            $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "amount";
        } else if (!empty($_GET["orderby"]) == "renewaldate") {
            $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "renewaldate";
        }
        $order = !empty($_GET["order"]) ? $_GET["order"] : "asc";
        //$orderAMT = !empty($_GET["orderby"]) ? $_GET["orderby"] : "amount";
        $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "renewaldate";


        $sql = "SELECT * FROM userdata WHERE userid='$x' ORDER BY " . $orderBy . " " . $order;

        $result = $mysqli->query($sql);

        $categoryOrder = "asc";
        $amountOrder = "asc";
        $renewaldateOrder = "asc";


        if ($orderBy == "category" && $order == "asc") {
            $categoryOrder = "desc";
        }
        if ($orderBy == "amount" && $order == "asc") {
            $amountOrder = "desc";
        }
        if ($orderBy == "renewaldate" && $order == "asc") {
            $renewaldateOrder = "desc";
        }


        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><a href="?orderby=category&order=<?php echo $categoryOrder; ?>">Category</a></th>
                    <th>Subscription</a></th>
                    <th>Service Provider</a></th>
                    <th><a href="?orderby=amount&order=<?php echo $amountOrder; ?>">Amount</a></th>
                    <th><a href="?orderby=renewaldate&order=<?php echo $renewaldateOrder; ?>">Renewal Date</a></th>
                    <th>Payment Portal</th>
                    <th>Remarks</th>
                    <th>Actions</th>


                </tr>
            </thead>
            <tbody>

                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td class="table-light">
                        <?php echo $row['id']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['category']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['subscription']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['serviceprovider']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['amount']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['renewaldate']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['paymentportal']; ?>
                    </td>
                    <td class="table-light">
                        <?php echo $row['remarks']; ?>
                    </td>
                    <td class="table-light">
                        <?php
                    echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                    echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                        ?>

                    </td>

                </tr>
                <?php
                } ?>
            </tbody>
        </table>

    </div>






</body>

</html>