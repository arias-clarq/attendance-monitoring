<?php
session_start();
include_once("dbcon.php");
$username = $_POST["username"];
$password = $_POST["password"];

$userSql = "SELECT * FROM `tbl_users` WHERE username = '{$username}' AND password = '{$password}'";

$result = $conn->query($userSql);

//get userID and positionID
$row = $result->fetch_assoc();
$userID = $row["userID"];
$positionID = $row["positionID"];

$_SESSION['userID'] =  $userID;
$_SESSION['positionID'] =  $positionID ;

if (strpos($username,"@admin") !== false && $result->num_rows > 0)
{
    // activate token
    $_SESSION['token'] = true;

    header("location: ../admin/dashboard.php");
} 
else if (strpos($username,"@staff") !== false && $result->num_rows > 0) 
{
     // activate token
     $_SESSION['token'] = true;

     header("location: ../admin/dashboard.php");
}
else
{
    $_SESSION['message'] = 'Incorrect Username or Password';
    header('location: ../index.php');
}
