<div class="row">
    <!-- Card 1: Users -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <?php
                $userSql = "SELECT COUNT(*) as users FROM `tbl_users`";
                $result = $conn->query($userSql);
                $row = $result->fetch_assoc();
                ?>
                <p class="card-text">Total users: <?=$row['users']?></p>
                <a href="users_mgt.php" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>

    <!-- Card 2: Revenue -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Staff</h5>
                <?php
                $staffSql = "SELECT COUNT(*) as staffs FROM `tbl_staff`";
                $result = $conn->query($staffSql);
                $row = $result->fetch_assoc();
                ?>
                <p class="card-text">Total Staff: <?=$row['staffs']?></p>
                <a href="users_mgt.php" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>

    <!-- Card 3: Orders -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Attendance</h5>
                <?php
                $currentDate = date("Y-m-d");
                $staffSql = "SELECT COUNT(date) as attendance FROM `tbl_attendance` WHERE date = '{$currentDate}'";
                $result = $conn->query($staffSql);
                $row = $result->fetch_assoc();
                ?>
                <p class="card-text">Today Attendee: <?=$row['attendance']?></p>
                <a href="attendance_monitoring.php" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
</div>