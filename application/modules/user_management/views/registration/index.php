<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Users</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                                <i class="fas fa-plus"></i> Add New User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi otomatis oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="add_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="add_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="add_username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="add_password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="add_password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="add_role">Role <span class="text-danger">*</span></label>
                        <select class="form-control" id="add_role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Edit User -->  
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit_role">Role <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_status" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include JavaScript -->
<script>
// Pastikan jQuery sudah loaded
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be loaded
    if (typeof jQuery === 'undefined') {
        setTimeout(function() {
            initUserRegistration();
        }, 100);
    } else {
        initUserRegistration();
    }
});

function initUserRegistration() {
    $(document).ready(function() {
        var userTable = $('#usersTable').DataTable({
            ajax: {
                url: "<?php echo base_url('user_registration/get_users_ajax'); ?>",
                type: "POST"
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'username'},
                {data: 'role'},
                {data: 'status'},
                {data: 'last_login'},
                {data: 'actions', orderable: false}
            ],
            processing: true,
            serverSide: false,
            responsive: true,
            order: [[0, 'desc']]
        });
        
        //Handle Add User Form Submit
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var submitBtn = $(this).find('button[type="submit"]');
            
            submitBtn.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: "<?php echo base_url('user_registration/create_user_ajax'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        });
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        userTable.ajax.reload();
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
                    submitBtn.prop('disabled', false).text('Save User');
                }
            });
        });

        // Handle Edit Button Click
        $(document).on('click', '.edit-btn', function() {
            var userId = $(this).data('id');
            
            $.ajax({
                url: "<?php echo base_url('user_registration/edit_user_ajax'); ?>",
                type: "POST",
                data: {user_id: userId},
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#edit_user_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $('#edit_email').val(response.data.email);
                        $('#edit_username').val(response.data.username);
                        $('#edit_role').val(response.data.role);
                        $('#edit_status').val(response.data.is_active);
                        $('#edit_password').val('');
                        
                        // Remove aria-hidden before showing modal
                        $('.wrapper').removeAttr('aria-hidden');
                        $('#editUserModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load user data!'
                    });
                }
            });
        });
        
        // Handle Edit User Form Submit
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var submitBtn = $(this).find('button[type="submit"]');
            
            submitBtn.prop('disabled', true).text('Updating...');
            
            $.ajax({
                url: "<?php echo base_url('user_registration/update_user_ajax'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        });
                        $('#editUserModal').modal('hide');
                        userTable.ajax.reload();
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
                    submitBtn.prop('disabled', false).text('Update User');
                }
            });
        });
        
        // Handle Delete Button Click
        $(document).on('click', '.delete-btn', function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete user "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo base_url('user_registration/delete_user_ajax'); ?>",
                        type: "POST",
                        data: {user_id: userId},
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message
                                });
                                userTable.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete user!'
                            });
                        }
                    });
                }
            });
        });

        setInterval(function() {
            userTable.ajax.reload(null, false);
        }, 30000); // Refresh every 30 seconds
    });
}
</script>
