<?php
session_start();
include_once("dbcon.php");
date_default_timezone_set('Asia/Manila');

if (isset($_POST['btn_timein'])) {

    //a function to prevent a staff clicking time in button again
    if (isset($_SESSION["attendanceID"])) {
        $_SESSION["error_msg"] = "You already time in for today";
        header("location: ../admin/dashboard.php");
        exit();
    }
    $staffID = $_SESSION['userID'];
    $workhoursID = $_SESSION['workhoursID'];

    $getWorkhours = "SELECT tbl_workhours.workhours FROM `tbl_staff` INNER JOIN tbl_workhours ON tbl_staff.workhoursID = tbl_workhours.workhoursID WHERE `staffID` = {$staffID}";
    $result = $conn->query($getWorkhours);
    $row = $result->fetch_assoc();
    $workhours = $row["workhours"];

    $startwork = '9:00:00';
    // Convert start work time to a timestamp
    $startwork_timestamp = strtotime($startwork);

    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    if ($startwork_timestamp <= $currentTime) {
        //1 is present
        $status = 1;
    } else if ($startwork_timestamp > $currentTime) {
        //2 is late
        $status = 2;
    }

    echo $status;

    $timeinSql = "INSERT INTO `tbl_attendance`(`staffID`, `date`, `timeIn`, `statusID`, `workhoursID`) 
    VALUES (
        '{$staffID}',
        '{$currentDate}',
        '{$currentTime}',
        '{$status}',
        '{$workhoursID}'
        )";

    $result = $conn->query($timeinSql);

    if ($result === true) {
        $attendanceID = $conn->insert_id;
        $_SESSION["attendanceID"] = $attendanceID;
        $_SESSION["success_msg"] = "Time-In Successfuly";
        header("location: ../admin/dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['btn_timeout'])) {
    if (isset($_SESSION["timeout_flag"]) == true) {
        $_SESSION["error_msg"] = "You already time out for today";
        header("location: ../admin/dashboard.php");
        exit();
    }

    if (!isset($_SESSION["attendanceID"])) {
        $_SESSION["error_msg"] = "You need to time in first";
        header("location: ../admin/dashboard.php");
        exit();
    }

    $staffID = $_SESSION['userID'];
    $workhoursID = $_SESSION['workhoursID'];

    $currentTime = date("H:i:s");
    $attendanceID = $_SESSION["attendanceID"];

    //will get the supposed workhours of the staff
    $getWorkhours = "SELECT tbl_workhours.workhours FROM `tbl_staff` INNER JOIN tbl_workhours ON tbl_staff.workhoursID = tbl_workhours.workhoursID WHERE `staffID` = {$staffID}";
    $result = $conn->query($getWorkhours);
    $row = $result->fetch_assoc();
    $workhours = $row["workhours"];

    $getTimein = "SELECT tbl_attendance.timeIn FROM `tbl_staff` INNER JOIN tbl_attendance ON tbl_staff.staffID = tbl_attendance.staffID WHERE tbl_attendance.staffID = {$staffID} AND tbl_attendance.attendanceID = '{$attendanceID}'";
    $result = $conn->query($getTimein);
    $row = $result->fetch_assoc();

    // Assuming $timein and $timeout are timestamps
    $timein = strtotime($row["timeIn"]);
    $timeout = strtotime($currentTime);
    
    // Calculate the difference in seconds
    $timeDiffSeconds = $timeout - $timein;
    
    // Convert seconds to hours
    $totalHours = round($timeDiffSeconds / 3600); // 3600 seconds = 1 hour
    
    // Determine if it's under, over, or equal to the specified work hours
    if ($totalHours < $workhours) {
        $worktime = 3;
    } elseif ($totalHours > $workhours) {
        $worktime = 2;
    } else {
        $worktime = 1;
    }

    $timeOutSql = "UPDATE `tbl_attendance` SET 
    `timeOut`='{$currentTime}',
    `worktime_statusID` = {$worktime}
    WHERE `staffID` = '{$staffID}' AND `attendanceID` = '{$attendanceID}'";

    $result = $conn->query($timeOutSql);

    if( $result === true) {
        $_SESSION["timeout_flag"] = true;
        $_SESSION["success_msg"] = "Time-Out Successfuly";
        header("location: ../admin/dashboard.php");
    }else{
        echo "Error: ". $conn->error;
    }
}