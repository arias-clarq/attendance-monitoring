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
                    <input type="hidden" name="position" value="1">

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="btn_delete" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>