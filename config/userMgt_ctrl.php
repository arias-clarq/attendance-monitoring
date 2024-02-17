<?php
include_once("dbcon.php");
session_start();
// function to add users
if (isset($_POST["btn_add"])) {
    if ($_POST["position"] == 1) {
        $position = '@admin';
        $_SESSION["userMsg"] = "Admin addition completed successfully.";
    } else if ($_POST["position"] == 2) {
        $position = '@staff';
        $workhoursID = $_POST["workhours"];
        $start_shift = $_POST["start_shift"];
        $_SESSION["userMsg"] = "Staff addition completed successfully.";
    }
    $username = $_POST['new_username'] . $position;
    $password = $_POST['new_password'];

    if ($_POST["position"] == 1) {
        $addSql = "INSERT INTO `tbl_users`(`username`, `password`) VALUES ('{$username}','$password')";
    } else if ($_POST["position"] == 2) {
        $addSql = "INSERT INTO `tbl_staff`(`username`, `password`, `workhoursID`,`shift_start`) VALUES ('{$username}','{$password}','{$workhoursID}','{$start_shift}')";
    }


    $result = $conn->query($addSql);
    if ($result === true) 
    {
        header("location: ../admin/users_mgt.php");
    } else 
    {
        echo "Error adding user: " . $conn->error;
    }
}

// function to edit users
if (isset($_POST["btn_edit"])) {
    if ($_POST["position"] == 1) {
        $position = '@admin';
        $_SESSION["userMsg"] = "Admin information updated successfully.";
    } else if ($_POST["position"] == 2) {
        $position = '@staff';
        $start_shift = $_POST["start_shift"];
        $workhoursID = $_POST["workhours"];
        $_SESSION["userMsg"] = "Staff information updated successfully.";
    }
    $id = $_POST["id"];
    $username = $_POST['edit_username'] . $position;
    $password = $_POST['edit_password'];

    if ($_POST["position"] == 1) {
        $editSql = "UPDATE `tbl_users` SET `username`='{$username}',`password`='{$password }' WHERE `userID` = {$id}";
    } else if ($_POST["position"] == 2) {
        $editSql = "UPDATE `tbl_staff` SET `username`='{$username}',`password`='{$password }',`workhoursID`='{$workhoursID}',`shift_start`='{$start_shift}' WHERE `staffID` = {$id}";
    }


    $result = $conn->query($editSql);
    if ($result === true) 
    {
        header("location: ../admin/users_mgt.php");
    } else 
    {
        echo "Error adding user: " . $conn->error;
    }
}

// function to delete users
if (isset($_POST["btn_delete"])) {
    $id = $_POST["id"];
    $position = $_POST["position"];
    if ($position == 1) {
        $deleteSql = "DELETE FROM `tbl_users` WHERE `userID` = {$id}";
        $_SESSION["deleteMsg"] = "Admin deletion completed successfully.";
    } else if ($position == 2) {
        $deleteSql = "DELETE FROM `tbl_staff` WHERE `staffID` = {$id}";
        $_SESSION["deleteMsg"] = "Staff deletion completed successfully.";
    }

    $result = $conn->query($deleteSql);
    if ($result === true) 
    {
        header("location: ../admin/users_mgt.php");
    } else 
    {
        echo "Error adding user: " . $conn->error;
    }
}