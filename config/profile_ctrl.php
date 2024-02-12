<?php
session_start();
include_once("dbcon.php");

if(isset($_POST['btn_upd'])){
    $staffID = $_SESSION['userID'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Mname = $_POST['Mname'];
    $contactNo = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $updSql = "UPDATE `tbl_staff` 
    SET 
    `password`='{$password}',
    `Fname`='{$Fname}',
    `Mname`='{$Mname}',
    `Lname`='{$Lname}',
    `contactNo`='{$contactNo}',
    `email`='{$email}' 
    WHERE `staffID` = {$staffID}";

    $result = $conn->query($updSql);
    if($result === true) {
        $_SESSION["success_msg"] = "Profile Updated successfuly";
        header("location: ../admin/dashboard.php");
    }else{
        echo "Error: ". $conn->error;
    }
}