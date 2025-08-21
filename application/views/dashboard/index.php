
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

<!-- Main Content  -->
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h1 class="card-title">
          Hello, <?= isset($user_name) && $user_name ? htmlspecialchars($user_name) : 'Guest' ?>
        </h1>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-info-circle mr-1"></i>
          Kirana News
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <p>Berita hari ini</p>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="http://localhost/ci3-noreload/assets/image1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="http://localhost/ci3-noreload/assets/image2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="http://localhost/ci3-noreload/assets/image3.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          Calendar
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <!-- Calendar Widget -->
        <div id="bootstrap-calendar" class="calendar-widget">
          <!-- Calendar Header -->
          <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
            <button type="button" class="btn btn-sm btn-outline-primary" id="prevMonth">
              <i class="fas fa-chevron-left"></i>
            </button>
            <h5 class="mb-0" id="currentMonthYear"></h5>
            <button type="button" class="btn btn-sm btn-outline-primary" id="nextMonth">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          
          <!-- Calendar Days -->
          <div class="calendar-grid">
            <div class="row calendar-header-days">
              <div class="col calendar-day-header">Min</div>
              <div class="col calendar-day-header">Sen</div>
              <div class="col calendar-day-header">Sel</div>
              <div class="col calendar-day-header">Rab</div>
              <div class="col calendar-day-header">Kam</div>
              <div class="col calendar-day-header">Jum</div>
              <div class="col calendar-day-header">Sab</div>
            </div>
            <div id="calendar-dates"></div>
          </div>
          
          <!-- Selected Date Info -->
          <div class="mt-3 p-3 bg-light rounded">
            <div id="selected-date-info">
              <small class="text-muted">Pilih tanggal pada kalender</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Kirana Event</h3>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Kirana Social Media</h3>
      </div>
      <div class="card-body">
      </div>
    </div>

  </div>
</div>

<!-- System Information -->
<!-- <div class="row">
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
</div> -->

<!-- Include Dashboard Styles -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/dashboard.css'); ?>">

<!-- Include JavaScript Base URL -->
<script>
var BASE_URL = "<?php echo base_url(); ?>";
</script>

<!-- Include Dashboard JavaScript -->
<script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
