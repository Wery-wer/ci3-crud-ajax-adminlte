      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#">CI3 CRUD System</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay" style="display: none;">
  <div class="text-center">
    <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
      <span class="sr-only">Loading...</span>
    </div>
    <div class="mt-2">
      <small>Loading...</small>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    // Real-time clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour12: false,
            timeZone: 'Asia/Jakarta'
        });
        $('#current-time').text(timeString);
    }
    
    // Update clock every second
    updateClock();
    setInterval(updateClock, 1000);
    
    // Global loading functions
    window.showLoading = function() {
        $('#loading-overlay').fadeIn(200);
    };
    
    window.hideLoading = function() {
        $('#loading-overlay').fadeOut(200);
    };
    
    // Global AJAX error handler
    $(document).ajaxError(function(event, xhr, settings, error) {
        hideLoading();
        
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan pada sistem. Silakan coba lagi.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
        
        console.error('AJAX Error:', {
            url: settings.url,
            error: error,
            status: xhr.status,
            response: xhr.responseText
        });
    });
    
    // Auto-refresh status management
    window.updateRefreshStatus = function(isActive, page = 1) {
        const statusElement = $('#refresh-status');
        
        if (isActive && page === 1) {
            statusElement.removeClass('badge-warning badge-danger')
                        .addClass('badge-success')
                        .html('<i class="fas fa-sync-alt fa-spin"></i> Auto Refresh: ON');
        } else if (!isActive) {
            statusElement.removeClass('badge-success badge-warning')
                        .addClass('badge-danger')
                        .html('<i class="fas fa-pause"></i> Auto Refresh: OFF');
        } else {
            statusElement.removeClass('badge-success badge-danger')
                        .addClass('badge-warning')
                        .html('<i class="fas fa-pause"></i> Auto Refresh: PAUSED');
        }
    };
    
    // Initialize refresh status
    updateRefreshStatus(true, 1);
});
</script>

</body>
</html>
