
<?php
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
                                @admin
                                <input type="hidden" name="position" value=1>
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