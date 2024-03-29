<?php
session_start();
include_once("dbcon.php");
date_default_timezone_set('Asia/Manila');

if (isset($_POST['btn_timein'])) {
    $staffID = $_SESSION['userID'];
    $workhoursID = $_SESSION['workhoursID'];
    $currentDate = date("Y-m-d");
    $checkSql = "SELECT * FROM `tbl_attendance` WHERE `staffID` = {$staffID} AND `date` = '{$currentDate}'";
    echo $checkSql;
    $check = $conn->query($checkSql);

    if ($check->num_rows > 0) {
        $_SESSION["error_msg"] = "You already time in for today";
        header("location: ../admin/dashboard.php");
        exit();
    } 
    else {
        $getWorkhours = "SELECT tbl_workhours.workhours, tbl_staff.shift_start FROM `tbl_staff` INNER JOIN tbl_workhours ON tbl_staff.workhoursID = tbl_workhours.workhoursID WHERE `staffID` = {$staffID}";
        $result = $conn->query($getWorkhours);
        $row = $result->fetch_assoc();
        $workhours = $row["workhours"];

        $startwork = $row["shift_start"];
        // Convert start work time to a timestamp
        $startwork_timestamp = strtotime($startwork);
        
        $currentTime = date("H:i:s");

        $currentTime_timestamp = strtotime($currentTime);

        if ($startwork_timestamp >= $currentTime_timestamp) {
            //1 is present
            $status = 1;
        } else if ($startwork_timestamp < $currentTime_timestamp) {
            //2 is late
            $status = 2;
        }

        $worktime = 4;

        $timeinSql = "INSERT INTO `tbl_attendance`(`staffID`, `date`, `timeIn`, `statusID`, `workhoursID`,`worktime_statusID`) 
    VALUES (
        '{$staffID}',
        '{$currentDate}',
        '{$currentTime}',
        '{$status}',
        '{$workhoursID}',
        '{$worktime}'
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
}

if (isset($_POST['btn_timeout'])) {
    $staffID = $_SESSION['userID'];
    $workhoursID = $_SESSION['workhoursID'];
    $currentDate = date("Y-m-d");

    $checkSql = "SELECT * FROM `tbl_attendance` WHERE `staffID` = {$staffID} AND `date` = '{$currentDate}' And `timeOut` IS NOT NULL";
    $check = $conn->query($checkSql);

    if ($check->num_rows > 0) {
        $_SESSION["error_msg"] = "You already time out for today";
        header("location: ../admin/dashboard.php");
        exit();
    } 

    $check2Sql = "SELECT * FROM `tbl_attendance` WHERE `staffID` = {$staffID} AND `date` = '{$currentDate}'";
    $check2 = $conn->query($check2Sql);
    if ($check2->num_rows == 0) {
        $_SESSION["error_msg"] = "You need to time in first";
        header("location: ../admin/dashboard.php");
        exit();
    }

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