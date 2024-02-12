<?php
session_start();
include_once("dbcon.php");
$username = $_POST["username"];
$password = $_POST["password"];

if (strpos($username, "@admin") !== false) {
    $userSql = "SELECT * FROM `tbl_users` WHERE username = '{$username}' AND password = '{$password}'";
} else if (strpos($username, "@staff") !== false) {
    $userSql = "SELECT * FROM `tbl_staff` WHERE username = '{$username}' AND password = '{$password}'";
}

$result = $conn->query($userSql);


if (strpos($username, "@admin") !== false && $result->num_rows > 0) {
    // activate token
    $_SESSION['token'] = true;

    //get userID and positionID
    $row = $result->fetch_assoc();
    $userID = $row["userID"];
    $username = $row["username"];
    $_SESSION['username'] = $username;
    $_SESSION['userID'] = $userID;

    header("location: ../admin/dashboard.php");
} else if (strpos($username, "@staff") !== false && $result->num_rows > 0) {
    // activate token
    $_SESSION['token'] = true;

    //get userID and positionID
    $row = $result->fetch_assoc();
    $userID = $row["staffID"];
    $username = $row["username"];
    $workhoursID = $row["workhoursID"];
    $_SESSION['username'] = $username;
    $_SESSION['userID'] = $userID;
    $_SESSION['workhoursID'] = $workhoursID;
    
    header("location: ../admin/dashboard.php");
} else {
    $_SESSION['message'] = 'Incorrect Username or Password';
    header('location: ../index.php');
}
