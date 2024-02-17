<!-- The Add User Modal -->
<div class="modal fade" id="add_staffModal">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Staff</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="../config/userMgt_ctrl.php" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">Username:</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="new_username" placeholder="Enter username" required>

                        <span class="input-group-text">
                            @staff
                            <input type="hidden" name="position" value=2>
                        </span>
                    </div>
                    <label for="">Password:</label>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" name="new_password" placeholder="Enter password" required>
                    </div>
                    <label for="">Workhours:</label>
                    <div class="input-group mb-2">
                        <select name="workhours" class="form-control">
                            <option>Select Work Hours</option>
                            <?php
                            $worktimeSql = "SELECT * FROM `tbl_workhours`";
                            $result = $conn->query($worktimeSql);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option value="<?= $row['workhoursID'] ?>"><?= $row['workhours'] ?> Hours</option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="">Start Shift:</label>
                    <div class="input-group mb-2">
                        <input type="time" class="form-control" name="start_shift" required>
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