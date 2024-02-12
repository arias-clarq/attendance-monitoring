<!-- messages -->
<div class="row text-center">
    <?php
    if (isset($_SESSION["success_msg"])) {
        ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION["success_msg"] ?>
            </strong>
        </div>
        <?php
    } else if (isset($_SESSION["error_msg"])) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>
                <?= $_SESSION["error_msg"] ?>
                </strong>
            </div>
    <?php }
    unset($_SESSION["success_msg"]);
    unset($_SESSION["error_msg"]);
    ?>
</div>

<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card">
            <form action="../config/attendance.php" method="post">
                <div class="card-body text-center">
                    <button name="btn_timein" type="submit" class="btn btn-success btn-lg btn-block">Time In</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <form action="../config/attendance.php" method="post">
                <div class="card-body text-center">
                    <button name="btn_timeout" type="submit" class="btn btn-danger btn-lg btn-block">Time Out</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="container mt-3 text-center">
        <h2>Your Attendance</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $staffID = $_SESSION['userID'];
                $count = 1;
                $attendanceSql = "SELECT * FROM `tbl_attendance` 
                INNER JOIN tbl_staff ON tbl_attendance.staffID = tbl_staff.staffID 
                INNER JOIN tbl_status ON tbl_attendance.statusID = tbl_status.statusID
                WHERE tbl_attendance.staffID = {$staffID}";
                $result = $conn->query($attendanceSql);
                while ($row = $result->fetch_assoc()) {
                    $timein = strtotime($row['timeIn']);
                    if ($row['timeOut'] != null) {
                        $timeout = strtotime($row['timeOut']);
                    }
                    ?>
                    <tr>
                        <td>
                            <?= $count ?>
                        </td>
                        <td>
                            <?= date('F j, Y', strtotime($row['date'])) ?> |
                            <?= date('l', strtotime($row['date'])) ?>
                        </td>
                        <td class="text-capitalize">
                            <?= $row['Lname'] . ' , ' . $row['Fname'] . ' ' . $row['Mname'] ?>
                        </td>
                        <td>
                            <?= date('h:i A', $timein) ?>
                        </td>
                        <td>
                            <?php if ($row['timeOut'] != null) {
                                echo date('h:i A', $timeout);
                            } ?>
                        </td>
                        <td>
                            <?= $row['status'] ?>
                        </td>
                    </tr>
                    <?php $count++;
                } ?>
                <?php if ($result->num_rows == 0) { ?>
                    <tr>
                        <td colspan="6"> No Result Found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>