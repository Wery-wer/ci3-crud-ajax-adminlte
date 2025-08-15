<!-- Main content -->
<style>
/* Pastikan DataTables responsive dan menggunakan full width */
.dataTables_wrapper {
    width: 100% !important;
}

#usersTable {
    width: 100% !important;
}

.table-responsive {
    width: 100% !important;
    overflow-x: auto;
}

/* Force table to recalculate when sidebar changes */
.sidebar-collapse .content-wrapper .dataTables_wrapper,
.sidebar-open .content-wrapper .dataTables_wrapper {
    width: 100% !important;
}
</style>

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
                                <th>Department</th>
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
                        <select class="form-control" id="add_role" name="role_id" required>
                            <option value="">Select Role</option>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_department">Department</label>
                        <select class="form-control" id="add_department" name="department_id">
                            <option value="">Select Department</option>
                            <!-- Options will be loaded via AJAX -->
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
                        <select class="form-control" id="edit_role" name="role_id" required>
                            <option value="">Select Role</option>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_department">Department</label>
                        <select class="form-control" id="edit_department" name="department_id">
                            <option value="">Select Department</option>
                            <!-- Options will be loaded via AJAX -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
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
        // Load roles untuk dropdown
        loadRoles();
        
        // Load departments untuk dropdown
        loadDepartments();
        
        var userTable = $('#usersTable').DataTable({
            ajax: {
                url: "<?php echo base_url('user_registration/get_users_ajax'); ?>",
                type: "POST"
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'username'},
                {
                    data: 'role_name', //role_name ini diambil dari hasil convert JSON yang ada di dalam array table master_role
                    render: function(data, type, row) {
                        let color = 'info';
                        if (data.toLowerCase() === 'admin') color = 'danger';
                        else if (data.toLowerCase() === 'manager') color = 'warning';
                        else if (data.toLowerCase() === 'user') color = 'primary';
                        return '<span class="badge badge-' + color + '">' + data + '</span>';
                    }
                },
                {
                    data: 'department_name',
                    render: function(data, type, row) {
                        if (data) {
                            return '<span class="badge badge-info">' + data + '</span><br><small class="text-muted">' + (row.department_code || '') + '</small>';
                        } else {
                            return '<span class="badge badge-secondary">No Department</span>';
                        }
                    }
                },
                {
                    data: 'is_active',
                    render: function(data, type, row) {
                        return data == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    }
                },
                {
                    data: 'last_login',
                    render: function(data, type, row) {
                        return data ? data : 'Never';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<button class="btn btn-sm btn-warning edit-btn" data-id="'+row.id+'"><i class="fas fa-edit"></i> Edit</button> ' +
                               '<button class="btn btn-sm btn-danger delete-btn" data-id="'+row.id+'" data-name="'+row.name+'"><i class="fas fa-trash"></i> Delete</button>';
                    }
                }
            ],
            processing: true,
            serverSide: false,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            order: [[0, 'desc']],
            drawCallback: function() {
                // Force adjust columns after each draw
                this.api().columns.adjust();
            }
        });

        // untuk membuka modal edit
        $('#usersTable tbody').on('click', '.edit-btn', function() {
            var userId = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url('user_registration/get_user_by_id'); ?>",
                type: "POST",
                data: {id: userId},
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        var user = response.data;
                        $('#edit_user_id').val(user.id);
                        $('#edit_name').val(user.name);
                        $('#edit_email').val(user.email);
                        $('#edit_username').val(user.username);
                        $('#edit_role').val(user.role_id);
                        $('#edit_department').val(user.department_id);
                        $('#edit_status').val(user.is_active);
                        $('#editUserModal').modal('show');
                    } else {
                        alert('User not found!');
                    }
                },
                error: function() {
                    alert('Error retrieving user data.');
                }
            });
        });

        // untuk menambahkan user
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url('user_registration/add_user'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        userTable.ajax.reload();
                        alert('User added successfully!');
                    } else {
                        alert('Failed to add user: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error adding user.');
                }
            });
        });

        // untuk mengedit user
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url('user_registration/update_user'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $('#editUserModal').modal('hide');
                        $('#editUserForm')[0].reset();
                        userTable.ajax.reload();
                        alert('User updated successfully!');
                    } else {
                        alert('Failed to update user: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error updating user.');
                }
            });
        });

        // untuk menghapus user
        $('#usersTable tbody').on('click', '.delete-btn', function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            if (confirm('Are you sure you want to delete user "' + userName + '"?')) {
                $.ajax({
                    url: "<?php echo base_url('user_registration/delete_user'); ?>",
                    type: "POST",
                    data: {id: userId},
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            userTable.ajax.reload();
                            alert('User deleted successfully!');
                        } else {
                            alert('Failed to delete user: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error deleting user.');
                    }
                });
            }
        });

        // Handle sidebar toggle untuk responsive DataTables
        $(document).on('click', '[data-widget="pushmenu"]', function() {
            setTimeout(function() {
                // Force recalculate DataTable width
                userTable.columns.adjust();
                userTable.responsive.recalc();
                
                // Trigger window resize to force redraw
                $(window).trigger('resize');
            }, 350);
        });

        // Handle window resize
        $(window).on('resize', function() {
            clearTimeout(window.resizeTimer);
            window.resizeTimer = setTimeout(function() {
                userTable.columns.adjust();
                userTable.responsive.recalc();
            }, 250);
        });
    });
}

// function untuk load roles ke dropdown
function loadRoles() {
    $.ajax({
        url: "<?php echo base_url('user_registration/get_roles_ajax'); ?>",
        type: "POST",
        dataType: "json",
        success: function(response) {
            if (response.status && response.data) {
                var roleOptions = '<option value="">Select Role</option>';
                $.each(response.data, function(index, role) {
                    roleOptions += '<option value="' + role.id + '">' + role.role_name + '</option>';
                });
                $('#add_role').html(roleOptions);
                $('#edit_role').html(roleOptions);
            } else {
                $('#add_role').html('<option value="">No roles available</option>');
                $('#edit_role').html('<option value="">No roles available</option>');
            }
        },
        error: function() {
            console.log('Error loading roles');
            $('#add_role').html('<option value="">Error loading roles</option>');
            $('#edit_role').html('<option value="">Error loading roles</option>');
        }
    });
}

// function untuk load departments ke dropdown
function loadDepartments() {
    $.ajax({
        url: "<?php echo base_url('user_registration/get_departments_ajax'); ?>",
        type: "POST",
        dataType: "json",
        success: function(response) {
            if (response.status && response.data) {
                var departmentOptions = '<option value="">Select Department</option>';
                $.each(response.data, function(index, department) {
                    departmentOptions += '<option value="' + department.id + '">' + department.department_name + ' (' + department.department_code + ')</option>';
                });
                $('#add_department').html(departmentOptions);
                $('#edit_department').html(departmentOptions);
            } else {
                $('#add_department').html('<option value="">No departments available</option>');
                $('#edit_department').html('<option value="">No departments available</option>');
            }
        },
        error: function() {
            console.log('Error loading departments');
            $('#add_department').html('<option value="">Error loading departments</option>');
            $('#edit_department').html('<option value="">Error loading departments</option>');
        }
    });
}
</script>
