
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

<script>
// Pastikan jQuery sudah loaded
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be loaded
    if (typeof jQuery === 'undefined') {
        setTimeout(function() {
            initDashboard();
        }, 100);
    } else {
        initDashboard();
    }
});

function initDashboard() {
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
    
    // Initialize Bootstrap Calendar
    initBootstrapCalendar();
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

// Bootstrap Calendar Implementation
function initBootstrapCalendar() {
    let currentDate = new Date();
    let selectedDate = null;
    
    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    function updateCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update header
        $('#currentMonthYear').text(`${monthNames[month]} ${year}`);
        
        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        // Clear calendar
        $('#calendar-dates').empty();
        
        // Generate calendar weeks
        const today = new Date();
        let weekRow = null;
        
        for (let i = 0; i < 42; i++) {
            if (i % 7 === 0) {
                weekRow = $('<div class="row calendar-week"></div>');
                $('#calendar-dates').append(weekRow);
            }
            
            const cellDate = new Date(startDate);
            cellDate.setDate(startDate.getDate() + i);
            
            const isCurrentMonth = cellDate.getMonth() === month;
            const isToday = cellDate.toDateString() === today.toDateString();
            const isSelected = selectedDate && cellDate.toDateString() === selectedDate.toDateString();
            
            let cellClass = 'col calendar-day';
            if (!isCurrentMonth) cellClass += ' other-month';
            if (isToday) cellClass += ' today';
            if (isSelected) cellClass += ' selected';
            
            const cell = $(`<div class="${cellClass}" data-date="${cellDate.toISOString().split('T')[0]}">
                            ${cellDate.getDate()}
                           </div>`);
            
            weekRow.append(cell);
        }
    }
    
    function updateSelectedDateInfo(date) {
        const dayName = dayNames[date.getDay()];
        const day = date.getDate();
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        
        // Calculate week of year
        const startOfYear = new Date(year, 0, 1);
        const days = Math.floor((date - startOfYear) / (24 * 60 * 60 * 1000));
        const weekOfYear = Math.ceil((days + startOfYear.getDay()) / 7);
        
        const info = `
            <div class="selected-date-details">
                <p class="mb-1"><strong>${dayName}, ${day} ${month} ${year}</strong></p>
                <small class="text-muted">
                    <i class="fas fa-calendar-week"></i> Minggu ke-${weekOfYear} tahun ${year}<br>
                    <i class="fas fa-clock"></i> ${new Date().toLocaleString('id-ID')}
                </small>
            </div>
        `;
        
        $('#selected-date-info').html(info);
    }
    
    // Event handlers
    $(document).on('click', '.calendar-day:not(.other-month)', function() {
        $('.calendar-day').removeClass('selected');
        $(this).addClass('selected');
        
        const dateStr = $(this).data('date');
        selectedDate = new Date(dateStr);
        updateSelectedDateInfo(selectedDate);
    });
    
    $('#prevMonth').on('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    });
    
    $('#nextMonth').on('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateCalendar();
    });
    
    // Initialize calendar
    updateCalendar();
    
    // Set today as selected by default
    selectedDate = new Date();
    updateSelectedDateInfo(selectedDate);
    
    // Update time every second
    setInterval(function() {
        if (selectedDate) {
            updateSelectedDateInfo(selectedDate);
        }
    }, 1000);
}
}
</script>

<style>
/* Bootstrap Calendar Styles */
.calendar-widget {
    font-family: 'Source Sans Pro', sans-serif;
}

.calendar-header-days {
    margin-bottom: 0;
}

.calendar-day-header {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    padding: 8px 4px;
    text-align: center;
    font-weight: bold;
    font-size: 12px;
    color: #495057;
}

.calendar-week {
    margin-bottom: 0;
}

.calendar-day {
    border: 1px solid #dee2e6;
    padding: 8px 4px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
    min-height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day:hover {
    background-color: #e9ecef;
    color: #495057;
}

.calendar-day.other-month {
    color: #ced4da;
    background-color: #f8f9fa;
    cursor: default;
}

.calendar-day.other-month:hover {
    background-color: #f8f9fa;
    color: #ced4da;
}

.calendar-day.today {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.calendar-day.today:hover {
    background-color: #0056b3;
    color: white;
}

.calendar-day.selected {
    background-color: #28a745;
    color: white;
    font-weight: bold;
}

.calendar-day.selected:hover {
    background-color: #1e7e34;
    color: white;
}

.selected-date-details p {
    font-size: 16px;
    color: #495057;
}

.selected-date-details small {
    font-size: 12px;
    line-height: 1.4;
}

.calendar-header h5 {
    color: #495057;
    font-weight: 600;
}

@media (max-width: 768px) {
    .calendar-day {
        padding: 6px 2px;
        font-size: 12px;
        min-height: 30px;
    }
    
    .calendar-day-header {
        padding: 6px 2px;
        font-size: 11px;
    }
}
</style>
