<?php
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
                // if (strpos($row['username'], "@admin") !== false) {
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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal<?= $row['userID'] ?>">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php
                $count++;
                // }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- The Add User Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Users</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="../config/userMgt_ctrl.php" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">Username:</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="new_username" placeholder="Enter username"
                            required>

                        <span class="input-group-text">
                            <select class="form-select" name="position" required>
                                <option selected>Choose Position</option>
                                <?php
                                $positionSql = "SELECT * FROM `tbl_position`";
                                $result = $conn->query($positionSql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['positionID'] ?>">
                                        <?= $row['position'] ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                    <label for="">Password:</label>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" name="new_password" placeholder="Enter password"
                            required>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button name="btn_add" type="submit" class="btn btn-success">Confirm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php
$editSql = "SELECT * FROM `tbl_users`";
$editResult = $conn->query($editSql);
while ($row = $editResult->fetch_assoc()) {
    //filter to remove the "@admin" string
    $filteredUsername = str_replace(['@admin', '@staff'], '', $row['username']);
    ?>
    <!-- The Edit User Modal -->
    <div class="modal fade" id="editModal<?= $row['userID'] ?>">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="../config/userMgt_ctrl.php" method="post"
                    onsubmit="return validateForm('editForm<?= $row['userID'] ?>')">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="">Username:</label>
                        <div class="input-group mb-2">
                            <input type="text" value="<?= $filteredUsername ?>" class="form-control" name="edit_username"
                                placeholder="Enter username">
                            <span class="input-group-text">
                                <select class="form-select" name="position" required>
                                    <?php
                                    $positionSql = "SELECT * FROM `tbl_position`";
                                    $result = $conn->query($positionSql);
                                    while ($row2 = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row2['positionID'] ?>" <?php if($row['positionID'] == $row2['positionID']){echo 'selected';} ?>>
                                            <?= $row2['position'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                        </div>
                        <label for="">Password:</label>
                        <div class="input-group mb-2">
                            <input type="text" value="<?= $row['password'] ?>" class="form-control" name="edit_password"
                                placeholder="Enter password">
                        </div>
                        <input type="hidden" name="id" value="<?= $row['userID'] ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="btn_edit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

                <!-- prevent submission when select value is default -->
                <script>
                    function validateForm(formId) {
                        var positionSelect = document.forms[formId].elements["position"];

                        // Check if the selected option is the default one
                        if (positionSelect.value === "Choose Position") {
                            alert("Please choose a valid position.");
                            return false; // Prevent form submission
                        }

                        // If the selected option is not the default, the form will be submitted
                        return true;
                    }
                </script>

            </div>
        </div>
    </div>

    <!-- The Delete User Modal -->
    <div class="modal fade" id="deleteModal<?= $row['userID'] ?>">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete
                        <?= $row['username'] ?>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="../config/userMgt_ctrl.php" method="post">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5>Are you sure you want to delete this user?</h5>
                    </div>
                    <input type="hidden" name="id" value="<?= $row['userID'] ?>">

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="btn_delete" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php }
?>
<?php
include("../assets/template/header.php");
?>