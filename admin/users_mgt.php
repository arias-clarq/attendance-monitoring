<?php
session_start();
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
include_once '../config/dbcon.php';
?>

<div class="container mt-5">
    <h2>Users Management</h2>
    <?php
    if (isset($_SESSION['userMsg'])) {
        ?>
        <div class="alert alert-success  alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION['userMsg'] ?>
            </strong>
        </div>
        <?php
    } elseif (isset($_SESSION['deleteMsg'])) { ?>
        <div class="alert alert-danger  alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION['deleteMsg'] ?>
            </strong>
        </div>
    <?php }
    unset($_SESSION['deleteMsg']);
    unset($_SESSION['userMsg']);
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                    <?php include('admin-includes/modals/add-users.php'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $userID = $_SESSION['userID'];
            $userSql = "SELECT * FROM `tbl_users` WHERE userID != {$userID} ";
            $result = $conn->query($userSql);

            $count = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <?= $count ?>
                    </td>
                    <td>
                        <?= $row['username'] ?>
                    </td>
                    <td>**********</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal<?= $row['userID'] ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <?php include('admin-includes/modals/edit-users.php'); ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal<?= $row['userID'] ?>">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <?php include('admin-includes/modals/delete-users.php'); ?>
                    </td>
                </tr>
                <?php
                $count++;
            }
            ?>
        </tbody>
    </table>
</div>

<div class="container mt-5">
    <h2>Staff Management</h2>
    <?php
    if (isset($_SESSION['userMsg'])) {
        ?>
        <div class="alert alert-success  alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION['userMsg'] ?>
            </strong>
        </div>
        <?php
    } elseif (isset($_SESSION['deleteMsg'])) { ?>
        <div class="alert alert-danger  alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION['deleteMsg'] ?>
            </strong>
        </div>
    <?php }
    unset($_SESSION['deleteMsg']);
    unset($_SESSION['userMsg']);
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_staffModal">
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                    <?php include('admin-includes/modals/add-staff.php'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $userSql = "SELECT * FROM `tbl_staff`";
            $result = $conn->query($userSql);

            $count = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <?= $count ?>
                    </td>
                    <td>
                        <?= $row['username'] ?>
                    </td>
                    <td>**********</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#edit_staffModal<?= $row['staffID'] ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <?php include('admin-includes/modals/edit-staff.php'); ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete_staffModal<?= $row['staffID'] ?>">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <?php include('admin-includes/modals/delete-staff.php'); ?>
                    </td>
                </tr>
                <?php
                $count++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include("../assets/template/header.php");
?>