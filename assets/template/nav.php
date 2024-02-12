<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Attendance Monitoring System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav ms-auto">
                <?php
                $username = $_SESSION['username'];
                if (strpos($username, "@admin") == true) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="users_mgt.php"><i class="fa-solid fa-users fa-xl"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Users Management"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="attendance_monitoring.php"><i
                                class="fa-solid fa-clipboard-user fa-2xl" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Attendance Monitoring"></i></a>
                    </li>
                <?php } ?>
                <?php if (strpos($username, "@staff") == true) { ?>
                    <li class="nav-item">
                        <button class="btn nav-link" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fa-solid fa-user fa-xl" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Profile"></i>
                        </button>
                    </li>
                <?php } ?>
            </ul>

            <button class="btn bottom-icon" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa-solid fa-lg fa-right-from-bracket text-danger" data-bs-toggle="tooltip"
                    data-bs-placement="left" title="Logout"></i>
            </button>

            <!-- Logout Modal -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true"
                data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Logout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Are you sure you want to logout?</h5>
                        </div>
                        <div class="modal-footer">
                            <a href="../index.php" type="submit" class="btn btn-success">Confirm</a>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Modal -->
            <div class="modal fade" id="profileModal" tabindex="-1" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <form action="../config/profile_ctrl.php" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Staff Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $staffID = $_SESSION['userID'];
                                $staffSql = "SELECT * FROM `tbl_staff` WHERE `staffID` = {$staffID}";
                                $result = $conn->query($staffSql);
                                $staffrow = $result->fetch_assoc();
                                ?>
                                <div class="container">
                                    <div class="d-flex flex-row">
                                        <h4 class="fw-bold px-1">Username:
                                            <?= $_SESSION['username'] ?>
                                        </h4>
                                    </div>
                                    <div class="row px-2 mb-3">
                                        <div class="col-md-12 col-lg-4 px-1">
                                            <p class="fw-bold mb-0">First Name:</p>
                                            <input type="text" class="form-control" placeholder="Enter Firstname"
                                                value="<?= $staffrow['Fname'] ?>" name="Fname">
                                        </div>
                                        <div class="col-md-12 col-lg-4 px-1">
                                            <p class="fw-bold mb-0">Middle Name:</p>
                                            <input type="text" class="form-control" placeholder="Enter Middlename"
                                                value="<?= $staffrow['Mname'] ?>" name="Mname">
                                        </div>
                                        <div class="col-md-12 col-lg-4 px-1">
                                            <p class="fw-bold mb-0">Last Name:</p>
                                            <input type="text" class="form-control" placeholder="Enter Lastname"
                                                value="<?= $staffrow['Lname'] ?>" name="Lname">
                                        </div>
                                    </div>
                                    <div class="row px-2 mb-3">
                                        <div class="col-md-12 col-lg-4 px-1">
                                            <p class="fw-bold mb-0">Phone Number:</p>
                                            <input type="text" class="form-control" placeholder="Enter phone number"
                                                value="<?= $staffrow['contactNo'] ?>" name="contact">
                                        </div>
                                        <div class="col-md-12 col-lg-8 px-1">
                                            <p class="fw-bold mb-0">Email Address:</p>
                                            <input type="text" class="form-control" placeholder="Enter email"
                                                value="<?= $staffrow['email'] ?>" name="email">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row mb-3">
                                        <div class="col px-1">
                                            <p class="fw-bold mb-0">Password:</p>
                                            <input type="text" class="form-control" value="<?= $staffrow['password'] ?>"
                                                name="password">
                                        </div>
                                    </div>
                                    <!-- <div class="d-flex flex-row">
                                        <h4 class="fw-bold px-1">
                                            Change Password
                                        </h4>
                                    </div>
                                    <div class="d-flex flex-row mb-3">
                                        <div class="col px-1">
                                            <p class="mb-0 fw-bold">New Password:</p>
                                            <input type="password" class="form-control" name="new_password" required
                                                value="">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row mb-3">
                                        <div class="col px-1">
                                            <p class="mb-0 fw-bold">Re-type New Password:</p>
                                            <input type="password" class="form-control" name="retype_password" required
                                                value="">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button name="btn_upd" type="submit" class="btn btn-success">Save Changes</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>