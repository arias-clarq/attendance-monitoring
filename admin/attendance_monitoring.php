<?php
session_start();
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Attendance Report</h1>
</div>



<?php
include("../assets/template/header.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Initialize the WHERE clause for the SQL query
    $whereClause = " WHERE 1";

    // Check if date filter is provided
    if (!empty($_GET['date'])) {
        $dateFilter = $_GET['date'];
        $whereClause .= " AND date = '$dateFilter'";
    }

    // Check if username filter is provided
    if (!empty($_GET['username'])) {
        $usernameFilter = $_GET['username'];
        $whereClause .= " AND username = '$usernameFilter'";
    }

    // Check if status filter is provided
    if (!empty($_GET['status']) && $_GET['status'] != 'Select a Section') {
        $statusFilter = $_GET['status'];
        $whereClause .= " AND tbl_status.statusID = '$statusFilter'";
    }

    // Construct the SQL query with filters
    $attendanceSql = "SELECT * FROM `tbl_attendance` 
            INNER JOIN tbl_staff ON tbl_attendance.staffID = tbl_staff.staffID 
            INNER JOIN tbl_status ON tbl_attendance.statusID = tbl_status.statusID
            INNER JOIN tbl_workhours ON tbl_attendance.workhoursID = tbl_workhours.workhoursID
            INNER JOIN tbl_worktime_status ON tbl_attendance.worktime_statusID = tbl_worktime_status.worktime_statusID" . $whereClause;
} else {
    // If no filters provided, get all attendance records
    $attendanceSql = "SELECT * FROM `tbl_attendance` 
            INNER JOIN tbl_staff ON tbl_attendance.staffID = tbl_staff.staffID 
            INNER JOIN tbl_status ON tbl_attendance.statusID = tbl_status.statusID
            INNER JOIN tbl_workhours ON tbl_attendance.workhoursID = tbl_workhours.workhoursID
            INNER JOIN tbl_worktime_status ON tbl_attendance.worktime_statusID = tbl_worktime_status.worktime_statusID";
}

$count = 1;
$result = $conn->query($attendanceSql);

?>
<div class="container mt-5">
    <div class="container mb-3">
        <form action="" method="get">
            <div class="row">
                <div class="col">
                    <label for="">Sort By Date</label>
                    <input class="form-control" type="date" name="date">
                </div>

                <div class="col">
                    <label for="">Sort By Username</label>
                    <input placeholder="Enter username" class="form-control" type="text" name="username">
                </div>
                <div class="col">
                    <label for="">Sort By Status</label>
                    <select name="status" class="form-select">
                        <option disabled selected>Select a Section</option>
                        <option value="1">PRESENT</option>
                        <option value="2">LATE</option>
                        <option value="3">ABSENT</option>
                    </select>
                </div>
                <div class="col align-self-end">
                    <button class="btn btn-primary" type="submit" name="btn_attendance_filter_submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Date</th>
                <th>TimeIn</th>
                <th>TimeOut</th>
                <th>Status</th>
                <th>Workhours</th>
                <th>Start Shift</th>
                <th>WorkTime_Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                $timein = strtotime($row['timeIn']);
                $timeout = strtotime($row['timeOut']);
                $shift = strtotime($row['shift_start']);
            ?>
                <tr>
                    <td>
                        <?= $count ?>
                    </td>
                    <td>
                        <?= $row['username'] ?>
                    </td>
                    <td>
                        <?= date('F j, Y', strtotime($row['date'])) ?> |
                        <?= date('l', strtotime($row['date'])) ?>
                    </td>
                    <td>
                        <?= date('h:i A', $timein) ?>
                    </td>
                    <td>
                        <?php
                        if($row['timeOut'] != null){
                           echo date('h:i A', $timeout);
                        }else{
                            echo "PENDING";
                        }
                         ?>
                    </td>
                    <td>
                        <?= $row['status'] ?>
                    </td>
                    <td>
                        <?= $row['workhours'] ?> Hours
                    </td>
                    <td>
                        <?= date('h:i A', $shift)?>
                    </td>
                    <td>
                        <?= $row['worktime_status'] ?>
                    </td>
                </tr>
            <?php
                $count++;
            }
            ?>
            <?php if ($result->num_rows == 0) { ?>
                <tr>
                    <td colspan="9" class="text-center"> No Result Found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
