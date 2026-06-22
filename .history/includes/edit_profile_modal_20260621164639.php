<div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-profile-form" method="Post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $phone; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="college_name" placeholder="College Name" value="<?php echo $college; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>