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

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-users mr-2"></i>
          Users Data Management
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-success btn-sm ml-1" onclick="refreshUsersManual()">
            <i class="fas fa-sync-alt"></i> <span class="d-none d-sm-inline">Refresh</span>
          </button>
        </div>
      </div>
      
      <div class="card-body">
        <!-- Alert container -->
        <div id="alert-container"></div>
        
        <!-- Users table -->
        <div class="table-responsive">
          <table id="usersTable" class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Name</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 20%;">Department</th>
                <th style="width: 15%;">Created At</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be loaded via AJAX -->
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="card-footer">
        <small class="text-muted">
          <i class="fas fa-info-circle"></i>
          User list with department information. Data will auto-refresh every 3 seconds on page 1.
        </small>
      </div>
    </div>
  </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">
          <i class="fas fa-user-plus"></i>
          <span id="modal-title">Add New User</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="userForm">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">
                  <i class="fas fa-user"></i> Full Name <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="name" name="name" required>
                <small class="form-text text-muted">Enter user's full name (minimum 2 characters)</small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">
                  <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                </label>
                <input type="email" class="form-control" id="email" name="email" required>
                <small class="form-text text-muted">Enter a valid email address</small>
              </div>
            </div>
          </div>
          
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> All fields marked with <span class="text-danger">*</span> are required.
            Email addresses and names must be unique in the system.
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary" id="saveBtn">
            <i class="fas fa-save"></i> <span id="save-text">Save User</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be loaded
    if (typeof jQuery === 'undefined') {
        setTimeout(function() {
            initUsersPage();
        }, 100);
    } else {
        initUsersPage();
    }
});

function initUsersPage() {
$(document).ready(function() {
    let usersTable;
    let autoRefreshInterval;
    let isEditMode = false;
    let editUserId = null;
    let currentPage = 1;
    let isUserActive = false;
    let lastUserActivity = Date.now();
    
    // Initialize DataTable
    function initializeDataTable() {
        usersTable = $('#usersTable').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets: 0,
                    responsivePriority: 1
                },
                {
                    responsivePriority: 1,
                    targets: 1
                },
                {
                    responsivePriority: 2,
                    targets: 2
                },
                {
                    responsivePriority: 3,
                    targets: 3
                },
                {
                    responsivePriority: 4,
                    targets: 4
                },
                {
                    responsivePriority: 1,
                    targets: -1,
                    orderable: false
                }
            ],
            order: [[4, 'desc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            language: {
                emptyTable: "No users found",
                zeroRecords: "No matching users found",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "Showing 0 to 0 of 0 users",
                infoFiltered: "(filtered from _MAX_ total users)",
                search: "Search users:",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            drawCallback: function(settings) {
                currentPage = this.api().page.info().page + 1;
                updateRefreshStatus(autoRefreshInterval !== null, currentPage);
            }
        });
        
        // Track page changes
        usersTable.on('page.dt', function() {
            setTimeout(function() {
                currentPage = usersTable.page.info().page + 1;
                updateRefreshStatus(autoRefreshInterval !== null, currentPage);
            }, 100);
        });
    }
    
    // Track user activity
    function trackUserActivity() {
        $(document).on('mousedown keydown scroll touchstart', function() {
            isUserActive = true;
            lastUserActivity = Date.now();
        });
        
        // Reset user activity after 2 seconds of inactivity
        setInterval(function() {
            if (Date.now() - lastUserActivity > 2000) {
                isUserActive = false;
            }
        }, 1000);
    }
    
    // Load users data
    function loadUsers() {
        $.ajax({
            url: '<?= base_url("user_management/get_users_ajax") ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    populateTable(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading users:', error);
                showAlert('Error loading users data. Please refresh the page.', 'danger');
            }
        });
    }
    
    // Populate table with data
    function populateTable(users) {
        usersTable.clear();
        
        users.forEach(function(user, index) {
            usersTable.row.add([
                index + 1,
                escapeHtml(user.name),
                escapeHtml(user.email),
                user.department_name ? 
                    `<span class="badge badge-info">${escapeHtml(user.department_name)}</span><br><small class="text-muted">${escapeHtml(user.department_code || '')}</small>` : 
                    '<span class="badge badge-secondary">No Department</span>',
                formatDate(user.created_at),
                `<div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>`
            ]);
        });
        
        usersTable.draw();
    }
    
    // Auto refresh functionality
    function startAutoRefresh() {
        // Only auto-refresh on page 1 and when user is not actively interacting
        autoRefreshInterval = setInterval(function() {
            if (currentPage === 1 && !isUserActive && !$('#userModal').hasClass('show')) {
                loadUsers();
            }
        }, 3000);
        
        updateRefreshStatus(true, currentPage);
    }
    
    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
        updateRefreshStatus(false, currentPage);
    }
    
    // Manual refresh
    window.refreshUsersManual = function() {
        showLoading();
        loadUsers();
        setTimeout(hideLoading, 500);
        
        showAlert('Data refreshed successfully!', 'success', 2000);
    };
    
    // Modal functions
    window.openCreateModal = function() {
        isEditMode = false;
        editUserId = null;
        $('#userForm')[0].reset();
        $('#modal-title').text('Add New User');
        $('#save-text').text('Save User');
        $('#userModalLabel i').attr('class', 'fas fa-user-plus');
    };
    
    window.editUser = function(id) {
        isEditMode = true;
        editUserId = id;
        
        showLoading();
        
        $.ajax({
            url: '<?= base_url("user_management/get_users_ajax") ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    const user = response.data.find(u => u.id == id);
                    if (user) {
                        $('#name').val(user.name);
                        $('#email').val(user.email);
                        $('#save-text').text('Update User');
                        $('#userModalLabel i').attr('class', 'fas fa-user-edit');
                        $('#userModal').modal('show');
                    }
                }
            },
            error: function() {
                hideLoading();
                showAlert('Error loading user data!', 'danger');
            }
        });
    };
    
    window.deleteUser = function(id) {
        Swal.fire({
            title: 'Delete User?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: '<?= base_url("user_management/delete_user_ajax") ?>',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        hideLoading();
                        
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'User has been deleted successfully.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to delete user.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Network error occurred while deleting user.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    };
    
    // Form submission
    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        
        const url = isEditMode ? 
            '<?= base_url("user_management/update_user_ajax") ?>' : 
            '<?= base_url("user_management/create_user_ajax") ?>';
        
        const formData = {
            name: $('#name').val().trim(),
            email: $('#email').val().trim()
        };
        
        if (isEditMode) {
            formData.id = editUserId;
        }
        
        showLoading();
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    $('#userModal').modal('hide');
                    
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    loadUsers();
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function() {
                hideLoading();
                showAlert('Network error occurred. Please try again.', 'danger');
            }
        });
    });
    
    // Utility functions
    function showAlert(message, type, duration = 5000) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('#alert-container').html(alertHtml);
        
        if (duration > 0) {
            setTimeout(function() {
                $('#alert-container .alert').fadeOut();
            }, duration);
        }
    }
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            timeZone: 'Asia/Jakarta'
        });
    }
    
    // Modal events
    $('#userModal').on('shown.bs.modal', function() {
        stopAutoRefresh();
        $('#name').focus();
    });
    
    $('#userModal').on('hidden.bs.modal', function() {
        startAutoRefresh();
    });
    
    // Handle sidebar toggle untuk responsive DataTables
    $(document).on('click', '[data-widget="pushmenu"]', function() {
        setTimeout(function() {
            // Force recalculate DataTable width
            usersTable.columns.adjust();
            usersTable.responsive.recalc();
            
            // Trigger window resize to force redraw
            $(window).trigger('resize');
        }, 350);
    });

    // Handle window resize
    $(window).on('resize', function() {
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(function() {
            usersTable.columns.adjust();
            usersTable.responsive.recalc();
        }, 250);
    });
    
    // Initialize everything
    initializeDataTable();
    trackUserActivity();
    loadUsers();
    startAutoRefresh();
});
}
</script>
