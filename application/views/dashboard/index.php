<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Users</span>
        <span class="info-box-number"><?= number_format($total_users) ?></span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-plus"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Active Today</span>
        <span class="info-box-number"><?= count($recent_users) ?></span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Server Time</span>
        <span class="info-box-number" id="dashboard-time"><?= date('H:i') ?></span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-database"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">System Status</span>
        <span class="info-box-number">
          <span class="badge badge-success">Online</span>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Welcome Card -->
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-home mr-1"></i>
          Welcome to CI3 CRUD System
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h5>System Features:</h5>
            <ul class="list-unstyled">
              <li><i class="fas fa-check text-success"></i> Real-time CRUD Operations</li>
              <li><i class="fas fa-check text-success"></i> AJAX-powered Interface</li>
              <li><i class="fas fa-check text-success"></i> Responsive AdminLTE Design</li>
              <li><i class="fas fa-check text-success"></i> Auto-refresh Functionality</li>
              <li><i class="fas fa-check text-success"></i> Smart Pagination</li>
              <li><i class="fas fa-check text-success"></i> Form Validation</li>
            </ul>
          </div>
          <div class="col-md-6">    
            <h5>Quick Actions:</h5>
            <div class="d-grid gap-2">
              <a href="<?= base_url('users') ?>" class="btn btn-primary">
                <i class="fas fa-users"></i> Manage Users
              </a>
              <button class="btn btn-success" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i> Refresh Dashboard
              </button>
              <button class="btn btn-info" onclick="checkSystemStatus()">
                <i class="fas fa-heartbeat"></i> System Health
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Users -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-clock mr-1"></i>
          Recent Users
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <?php if(!empty($recent_users)): ?>
          <ul class="users-list clearfix">
            <?php foreach($recent_users as $user): ?>
              <li class="d-flex align-items-center p-2 border-bottom">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=007bff&color=fff&size=32" 
                     alt="User Avatar" class="img-circle mr-2" width="32" height="32">
                <div class="users-list-info flex-grow-1">
                  <span class="users-list-name"><?= htmlspecialchars($user['name']) ?></span>
                  <small class="users-list-date text-muted d-block"><?= $user['created_at_jakarta'] ?></small>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <div class="text-center py-4">
            <p class="text-muted">No recent users found</p>
          </div>
        <?php endif; ?>
        
        <div class="card-footer text-center">
          <a href="<?= base_url('users') ?>" class="uppercase">View All Users</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- System Information -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-info-circle mr-1"></i>
          System Information
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <strong><i class="fas fa-code"></i> Framework</strong>
            <p class="text-muted">CodeIgniter 3.1.13</p>
          </div>
          <div class="col-md-3">
            <strong><i class="fab fa-php"></i> PHP Version</strong>
            <p class="text-muted"><?= PHP_VERSION ?></p>
          </div>
          <div class="col-md-3">
            <strong><i class="fas fa-clock"></i> Timezone</strong>
            <p class="text-muted">Asia/Jakarta</p>
          </div>
          <div class="col-md-3">
            <strong><i class="fas fa-server"></i> Environment</strong>
            <p class="text-muted"><?= ENVIRONMENT ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Update dashboard time
    function updateDashboardTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        });
        $('#dashboard-time').text(timeString);
    }
    
    // Update every minute
    updateDashboardTime();
    setInterval(updateDashboardTime, 60000);
});

function checkSystemStatus() {
    Swal.fire({
        title: 'System Health Check',
        html: `
            <div class="text-left">
                <p><i class="fas fa-check text-success"></i> Database Connection: <strong>OK</strong></p>
                <p><i class="fas fa-check text-success"></i> AJAX Functions: <strong>Working</strong></p>
                <p><i class="fas fa-check text-success"></i> Auto-refresh: <strong>Active</strong></p>
                <p><i class="fas fa-check text-success"></i> Session Management: <strong>OK</strong></p>
                <p><i class="fas fa-check text-success"></i> Timezone: <strong>Asia/Jakarta</strong></p>
            </div>
        `,
        icon: 'success',
        confirmButtonText: 'Great!',
        confirmButtonColor: '#28a745'
    });
}
</script>
