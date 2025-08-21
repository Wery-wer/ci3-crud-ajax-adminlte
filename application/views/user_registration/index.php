<!-- Include User Registration Styles -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/user-registration.css'); ?>">

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
                                <th>Detail</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Add User dengan Tabs -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="addUserTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="user-info-tab" data-toggle="tab" href="#user-info" role="tab">
                                <i class="fas fa-user"></i> User Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="job-history-tab" data-toggle="tab" href="#job-history" role="tab">
                                <i class="fas fa-briefcase"></i> Riwayat Pekerjaan
                            </a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="addUserTabContent">
                        <!-- Page 1: User Information -->
                        <div class="tab-pane fade show active" id="user-info" role="tabpanel">
                            <div class="form-group">
                                <label for="add_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="add_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="add_dob">Tanggal Lahir</label>
                                <input type="text" class="form-control dob-picker" id="add_dob" name="tanggal_lahir" autocomplete="off" placeholder="dd.mm.yyyy">
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
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_department">Department</label>
                                <select class="form-control" id="add_department" name="department_id">
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                        </div>

                        <!-- Page 2: Riwayat Pekerjaan -->
                        <div class="tab-pane fade" id="job-history" role="tabpanel">
                            <div id="job-history-forms">
                                <div class="job-history-item border p-3 mb-3">
                                    <h6>Riwayat Pekerjaan #1</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <input type="text" class="form-control" name="job_history[0][namaperusahaan]" placeholder="PT. Nama Perusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title Pekerjaan</label>
                                                <input type="text" class="form-control" name="job_history[0][titlepekerjaan]" placeholder="Frontend Developer">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Masuk</label>
                                                <input type="text" class="form-control job-date-picker" name="job_history[0][tanggalmasuk]" placeholder="dd.mm.yyyy" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Keluar</label>
                                                <input type="text" class="form-control job-date-picker" name="job_history[0][tanggalkeluar]" placeholder="dd.mm.yyyy (kosongkan jika masih bekerja)" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Universitas/Pendidikan</label>
                                        <input type="text" class="form-control" name="job_history[0][universitas]" placeholder="Universitas Telkom">
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm remove-job-history" style="display: none;">
                                        <i class="fas fa-trash"></i> Hapus Riwayat Ini
                                    </button>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-success btn-sm" id="add-job-history">
                                <i class="fas fa-plus"></i> Tambah Riwayat Pekerjaan
                            </button>
                
                        </div>
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
                        <label for="edit_dob">Tanggal Lahir</label>
                        <input type="text" class="form-control dob-picker" id="edit_dob" name="tanggal_lahir" autocomplete="off" placeholder="dd.mm.yyyy">
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
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_department">Department</label>
                        <select class="form-control" id="edit_department" name="department_id">
                            <option value="">Select Department</option>
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

<!-- Modal Detail Riwayat Pekerjaan -->
<div class="modal fade" id="modalDetailRiwayat" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Riwayat Pekerjaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 id="user-info-header">Riwayat Pekerjaan</h6>
          <button type="button" class="btn btn-success btn-sm" id="add-new-job-history">
            <i class="fas fa-plus"></i> Tambah Riwayat Baru
          </button>
        </div>
        
        <div id="job-history-list">
          <!-- Job history akan dimuat di sini -->
        </div>
        
        <!-- Form untuk add/edit riwayat pekerjaan -->
        <div id="job-form-container" style="display: none;">
          <div class="card">
            <div class="card-header">
              <h6 id="job-form-title">Tambah Riwayat Pekerjaan</h6>
            </div>
            <div class="card-body">
              <form id="jobHistoryForm">
                <input type="hidden" id="job_id" name="job_id">
                <input type="hidden" id="job_user_id" name="user_id">
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_namaperusahaan">Nama Perusahaan <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="job_namaperusahaan" name="namaperusahaan" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_titlepekerjaan">Title Pekerjaan <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="job_titlepekerjaan" name="titlepekerjaan" required>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_tanggalmasuk">Tanggal Masuk <span class="text-danger">*</span></label>
                      <input type="text" class="form-control job-detail-date-picker" id="job_tanggalmasuk" name="tanggalmasuk" placeholder="dd.mm.yyyy" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_tanggalkeluar">Tanggal Keluar</label>
                      <input type="text" class="form-control job-detail-date-picker" id="job_tanggalkeluar" name="tanggalkeluar" placeholder="dd.mm.yyyy (kosongkan jika masih bekerja)" autocomplete="off">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="job_universitas">Universitas/Pendidikan</label>
                  <input type="text" class="form-control" id="job_universitas" name="universitas">
                </div>
                
                <div class="text-right">
                  <button type="button" class="btn btn-secondary" id="cancel-job-form">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Include JavaScript Base URL -->
<script>
var BASE_URL = "<?php echo base_url(); ?>";
</script>

<!-- Include External JavaScript -->
<script src="<?php echo base_url('assets/js/user-registration.js'); ?>"></script>
