<!-- Include User Management Styles -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/user-management.css'); ?>">

<!-- Include JavaScript Base URL -->
<script>
var BASE_URL = "<?php echo base_url(); ?>";
</script>

<!-- Include User Management JavaScript -->
<script src="<?php echo base_url('assets/js/user-management.js'); ?>"></script>

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


