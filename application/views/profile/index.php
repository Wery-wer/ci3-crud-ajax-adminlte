<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=007bff&color=fff&size=128"
                                 alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= htmlspecialchars($user['name']) ?></h3>

                        <p class="text-muted text-center">
                            <span class="badge badge-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'manager' ? 'warning' : 'primary') ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <span class="float-right"><?= htmlspecialchars($user['username']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <span class="float-right"><?= htmlspecialchars($user['email']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b> 
                                <span class="float-right">
                                    <span class="badge badge-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                        <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Last Login</b> 
                                <span class="float-right text-muted">
                                    <?= $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Never' ?>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Member Since</b> 
                                <span class="float-right text-muted">
                                    <?= date('d M Y', strtotime($user['created_at'])) ?>
                                </span>
                            </li>
                        </ul>

                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#editProfileModal">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Profile Activity -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="timeline timeline-inverse">
                                    <div class="time-label">
                                        <span class="bg-success">
                                            Today
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fas fa-user bg-info"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> <?= date('H:i') ?></span>
                                            <h3 class="timeline-header">Profile viewed</h3>
                                            <div class="timeline-body">
                                                You accessed your profile page.
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-sign-in-alt bg-success"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 
                                                <?= $user['last_login'] ? date('H:i', strtotime($user['last_login'])) : 'Unknown' ?>
                                            </span>
                                            <h3 class="timeline-header">Last login</h3>
                                            <div class="timeline-body">
                                                You logged in to the system.
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProfileForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">New Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" readonly>
                        <small class="form-text text-muted">Role cannot be changed. Contact administrator if needed.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery === 'undefined') {
        setTimeout(function() {
            initProfile();
        }, 100);
    } else {
        initProfile();
    }
});

function initProfile() {
    $(document).ready(function() {
        $('#editProfileForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var submitBtn = $(this).find('button[type="submit"]');
            
            submitBtn.prop('disabled', true).text('Updating...');
            
            $.ajax({
                url: "<?php echo base_url('profile/update_profile_ajax'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong!'
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text('Update Profile');
                }
            });
        });
    });
}
</script>
