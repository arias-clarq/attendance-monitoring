<?php
$filteredUsername = str_replace(['@admin', '@staff'], '', $row['username']);
?>
<!-- The Edit User Modal -->
<div class="modal fade" id="edit_staffModal<?= $row['staffID'] ?>">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Staff</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="../config/userMgt_ctrl.php" method="post"
                onsubmit="return validateForm('editForm<?= $row['staffID'] ?>')">
                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">Username:</label>
                    <div class="input-group mb-2">
                        <input type="text" value="<?= $filteredUsername ?>" class="form-control" name="edit_username"
                            placeholder="Enter username">
                        <span class="input-group-text">
                            @staff
                            <input type="hidden" name="position" value=2>
                        </span>
                    </div>
                    <label for="">Password:</label>
                    <div class="input-group mb-2">
                        <input type="text" value="<?= $row['password'] ?>" class="form-control" name="edit_password"
                            placeholder="Enter password">
                    </div>
                    <label for="">Workhours:</label>
                    <div class="input-group mb-2">
                        <select name="workhours" class="form-control">
                            <?php
                            $worktimeSql = "SELECT * FROM `tbl_workhours`";
                            $result2 = $conn->query($worktimeSql);
                            while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                <option value="<?= $row2['workhoursID'] ?>" <?php if($row2['workhoursID']==$row['workhoursID']){echo "selected";} ?>>
                                    <?= $row2['workhours'] ?> Hours
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?= $row['staffID'] ?>">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="btn_edit" class="btn btn-success">Confirm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>