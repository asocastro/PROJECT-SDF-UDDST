<?php
session_start();
$x = $_SESSION['userid'];
$sql = "SELECT * FROM userdate WHERE userid='$x'";

if ($_GET['sort'] == 'amount')
{
    $sql .= " ORDER BY amount";
    header("location: index.php");
            exit();
}
?>