/**
 * User Registration JavaScript
 * Handles all CRUD operations, modal management, and data table functionality
 */

// Global variables
let userTable;
let jobHistoryCounter = 1;
let currentUserId = null;

// Main initialization function
document.addEventListener("DOMContentLoaded", function () {
	if (typeof jQuery === "undefined") {
		setTimeout(function () {
			initUserRegistration();
		}, 100);
	} else {
		initUserRegistration();
	}
});

function initUserRegistration() {
	$(document).ready(function () {
		// Initialize all date pickers
		$(".dob-picker").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});

		$(".job-date-picker").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});

		$(".job-detail-date-picker").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});

		// Load roles and departments for dropdowns
		loadRoles();
		loadDepartments();

		// Initialize DataTable
		initDataTable();

		// Initialize all event handlers
		initEventHandlers();
		initDynamicJobHistory();
		initJobHistoryCRUD();
		initModalEventHandlers();

		// Handle sidebar toggle for responsive DataTables
		$(document).on("click", '[data-widget="pushmenu"]', function () {
			setTimeout(function () {
				userTable.columns.adjust();
				userTable.responsive.recalc();
				$(window).trigger("resize");
			}, 350);
		});

		// Handle window resize
		$(window).on("resize", function () {
			clearTimeout(window.resizeTimer);
			window.resizeTimer = setTimeout(function () {
				userTable.columns.adjust();
				userTable.responsive.recalc();
			}, 250);
		});
	});
}

// Initialize DataTable
function initDataTable() {
	userTable = $("#usersTable").DataTable({
		ajax: {
			url: BASE_URL + "user_registration/get_users_ajax",
			type: "POST",
		},
		columns: [
			{ data: "id" },
			{ data: "name" },
			{ data: "username" },
			{
				data: "role_name",
				render: function (data, type, row) {
					let color = "info";
					if (data.toLowerCase() === "admin") color = "danger";
					else if (data.toLowerCase() === "manager") color = "warning";
					else if (data.toLowerCase() === "user") color = "primary";
					return '<span class="badge badge-' + color + '">' + data + "</span>";
				},
			},
			{
				data: "department_name",
				render: function (data, type, row) {
					if (data) {
						return (
							'<span class="">' +
							data +
							'</br></span><small class="text-muted">' +
							(row.department_code || "") +
							"</small>"
						);
					} else {
						return '<span class="">No Department</span>';
					}
				},
			},
			{
				data: "is_active",
				render: function (data, type, row) {
					return data == 1
						? '<span class="badge badge-success">Active</span>'
						: '<span class="badge badge-danger">Inactive</span>';
				},
			},
			{
				data: "last_login",
				render: function (data, type, row) {
					return data ? data : "Never";
				},
			},
			{
				data: null,
				orderable: false,
				render: function (data, type, row) {
					return (
						'<button class="btn btn-sm btn-info detail-btn" data-id="' +
						row.id +
						'">Detail</button>'
					);
				},
			},
			{
				data: null,
				orderable: false,
				render: function (data, type, row) {
					return (
						'<button class="btn btn-sm btn-warning edit-btn" data-id="' +
						row.id +
						'"><i class="fas fa-edit"></i> Edit</button> ' +
						'<button class="btn btn-sm btn-danger delete-btn" data-id="' +
						row.id +
						'" data-name="' +
						row.name +
						'"><i class="fas fa-trash"></i> Delete</button>'
					);
				},
			},
		],
		processing: true,
		serverSide: false,
		responsive: true,
		scrollX: true,
		autoWidth: true,
		order: [[0, "desc"]],
		drawCallback: function () {
			this.api().columns.adjust();
		},
	});

	// Make userTable globally accessible
	window.userTable = userTable;
}

// Initialize main event handlers
function initEventHandlers() {
	// Edit user button
	$("#usersTable tbody").on("click", ".edit-btn", function () {
		var userId = $(this).data("id");
		$.ajax({
			url: BASE_URL + "user_registration/get_user_by_id",
			type: "POST",
			data: { id: userId },
			dataType: "json",
			success: function (response) {
				if (response.status) {
					var user = response.data;
					$("#edit_user_id").val(user.id);
					$("#edit_name").val(user.name);
					$("#edit_email").val(user.email);
					$("#edit_username").val(user.username);
					$("#edit_role").val(user.role_id);
					$("#edit_department").val(user.department_id);
					$("#edit_status").val(user.is_active);
					$("#edit_dob").val(user.tanggal_lahir || "");
					$("#editUserModal").modal("show");
				} else {
					alert("User not found!");
				}
			},
			error: function () {
				alert("Error retrieving user data.");
			},
		});
	});

	// Add user form submission
	$("#addUserForm").on("submit", function (e) {
		e.preventDefault();
		$.ajax({
			url: BASE_URL + "user_registration/add_user",
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (response) {
				if (response.status) {
					$("#addUserModal").modal("hide");
					$("#addUserForm")[0].reset();
					userTable.ajax.reload();
					Swal.fire({
						icon: "success",
						title: "Success",
						text: response.message,
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: response.message,
					});
				}
			},
			error: function () {
				alert("Error adding user.");
			},
		});
	});

	// Edit user form submission
	$("#editUserForm").on("submit", function (e) {
		e.preventDefault();
		$.ajax({
			url: BASE_URL + "user_registration/update_user",
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (response) {
				if (response.status) {
					$("#editUserModal").modal("hide");
					$("#editUserForm")[0].reset();
					userTable.ajax.reload();
					Swal.fire({
						icon: "success",
						title: "Success",
						text: "User updated successfully!",
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "Failed to update user: " + response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Error updating user.",
				});
			},
		});
	});

	// Delete user button
	$("#usersTable tbody").on("click", ".delete-btn", function () {
		var userId = $(this).data("id");
		var userName = $(this).data("name");
		Swal.fire({
			title: "Delete User",
			text: 'Are you sure you want to delete user "' + userName + '"?',
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, delete",
			cancelButtonText: "Cancel",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: BASE_URL + "user_registration/delete_user",
					type: "POST",
					data: { id: userId },
					dataType: "json",
					success: function (response) {
						if (response.status) {
							userTable.ajax.reload();
							Swal.fire({
								icon: "success",
								title: "Success",
								text: response.message,
							});
						} else {
							Swal.fire({
								icon: "error",
								title: "Error",
								text: response.message,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: "error",
							title: "Error",
							text: "Error deleting user.",
						});
					},
				});
			}
		});
	});

	// Detail button
	$(document).on("click", ".detail-btn", function () {
		var userId = $(this).data("id");
		var userName = $(this).closest("tr").find("td:nth-child(2)").text();

		$("#detailModalLabel").text("Riwayat Pekerjaan");
		$("#user-info-header").text(userName);

		$("#modalDetailRiwayat").data("user-id", userId);
		window.currentUserId = userId;
		currentUserId = userId;

		// Also set the hidden field immediately
		$("#job_user_id").val(userId);

		console.log("Detail button clicked - User ID set to:", userId);

		$.getJSON(
			BASE_URL + "riwayat_pekerjaan/get_user_with_history/" + userId,
			function (res) {
				displayJobHistory(res.riwayat);
				$("#modalDetailRiwayat").modal("show");
			}
		).fail(function (xhr, status, error) {
			console.error("Error loading user detail:", error);
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Gagal memuat detail user. Periksa koneksi dan coba lagi.",
			});
		});
	});
}

// Dynamic Job History Management
function initDynamicJobHistory() {
	// Initialize date pickers for job history
	function initJobDatePickers() {
		$(".job-date-picker").datepicker("destroy").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});
	}

	// Add new job history form
	$(document).on("click", "#add-job-history", function () {
		let newJobForm = `
            <div class="job-history-item border p-3 mb-3">
                <h6>Riwayat Pekerjaan #${jobHistoryCounter + 1}</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Perusahaan</label>
                            <input type="text" class="form-control" name="job_history[${jobHistoryCounter}][namaperusahaan]" placeholder="PT. Nama Perusahaan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title Pekerjaan</label>
                            <input type="text" class="form-control" name="job_history[${jobHistoryCounter}][titlepekerjaan]" placeholder="Frontend Developer">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="text" class="form-control job-date-picker" name="job_history[${jobHistoryCounter}][tanggalmasuk]" placeholder="dd.mm.yyyy" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Keluar</label>
                            <input type="text" class="form-control job-date-picker" name="job_history[${jobHistoryCounter}][tanggalkeluar]" placeholder="dd.mm.yyyy (kosongkan jika masih bekerja)" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Universitas/Pendidikan</label>
                    <input type="text" class="form-control" name="job_history[${jobHistoryCounter}][universitas]" placeholder="Universitas Telkom">
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-job-history">
                    <i class="fas fa-trash"></i> Hapus Riwayat Ini
                </button>
            </div>
        `;

		$("#job-history-forms").append(newJobForm);
		jobHistoryCounter++;

		$(".remove-job-history").show();
		initJobDatePickers();
	});

	// Remove job history form
	$(document).on("click", ".remove-job-history", function () {
		$(this).closest(".job-history-item").remove();

		if ($(".job-history-item").length <= 1) {
			$(".remove-job-history").hide();
		}

		$(".job-history-item").each(function (index) {
			$(this)
				.find("h6")
				.text("Riwayat Pekerjaan #" + (index + 1));
		});
	});

	// Initialize date pickers on modal show
	$("#addUserModal").on("shown.bs.modal", function () {
		initJobDatePickers();
		$(".dob-picker").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});
	});

	// Reset form when modal closes
	$("#addUserModal").on("hidden.bs.modal", function () {
		$('#addUserTabs a[href="#user-info"]').tab("show");
		$(".job-history-item").not(":first").remove();
		$(".job-history-item:first input").val("");
		$(".remove-job-history").hide();
		jobHistoryCounter = 1;
		$("#addUserForm")[0].reset();
	});
}

// Job History CRUD Operations
function initJobHistoryCRUD() {
	// Initialize date pickers for job detail form
	function initJobDetailDatePickers() {
		$(".job-detail-date-picker").datepicker("destroy").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});
	}

	// Show add new job form
	$(document).on("click", "#add-new-job-history", function () {
		console.log("Add new job history clicked", {
			currentUserId: currentUserId,
			globalCurrentUserId: window.currentUserId,
		});

		// Ensure we have a valid user ID
		if (!currentUserId && !window.currentUserId) {
			console.error("No current user ID found!");
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "User ID tidak ditemukan. Silakan tutup modal dan buka kembali.",
			});
			return;
		}

		const userId = currentUserId || window.currentUserId;

		$("#job-form-title").text("Tambah Riwayat Pekerjaan");
		$("#jobHistoryForm")[0].reset();
		$("#job_id").val(""); // Clear job_id for add operation
		$("#job_user_id").val(userId);

		console.log("Form prepared with user_id:", userId);

		$("#job-form-container").show();
		setTimeout(function () {
			initJobDetailDatePickers();
		}, 100);
	});

	// Show edit job form
	$(document).on("click", ".edit-job-btn", function () {
		console.log("Edit job clicked");
		const job = JSON.parse($(this).attr("data-job"));
		$("#job-form-title").text("Edit Riwayat Pekerjaan");
		$("#job_id").val(job.id);
		$("#job_user_id").val(job.user_id);
		$("#job_namaperusahaan").val(job.namaperusahaan);
		$("#job_titlepekerjaan").val(job.titlepekerjaan);
		$("#job_tanggalmasuk").val(job.tanggalmasuk);
		$("#job_tanggalkeluar").val(job.tanggalkeluar || "");
		$("#job_universitas").val(job.universitas || "");

		$("#job-form-container").show();
		setTimeout(function () {
			initJobDetailDatePickers();
		}, 100);
	});

	// Cancel job form
	$(document).on("click", "#cancel-job-form", function () {
		$("#job-form-container").hide();
	});

	// Submit job form
	$(document).on("submit", "#jobHistoryForm", function (e) {
		e.preventDefault();

		const isEdit = $("#job_id").val() !== "";
		const url = isEdit
			? BASE_URL + "riwayat_pekerjaan/update_job_history"
			: BASE_URL + "riwayat_pekerjaan/add_job_history";

		// Ambil data form dan filter
		let formData = $(this).serializeArray();

		// Untuk operasi tambah, hapus job_id dari data form
		if (!isEdit) {
			formData = formData.filter((item) => item.name !== "job_id");
		}

		// Konversi kembali ke format string
		const filteredFormData = $.param(formData);

		// Debug: Tampilkan data form di console
		console.log("Form submission:", {
			isEdit: isEdit,
			url: url,
			originalFormData: $(this).serialize(),
			filteredFormData: filteredFormData,
			currentUserId: currentUserId,
		});

		// Validasi tambahan
		const namaperusahaan = $("#job_namaperusahaan").val();
		const titlepekerjaan = $("#job_titlepekerjaan").val();
		const tanggalmasuk = $("#job_tanggalmasuk").val();

		if (!namaperusahaan || !titlepekerjaan || !tanggalmasuk) {
			Swal.fire({
				icon: "error",
				title: "Validasi Error",
				text: "Nama perusahaan, title pekerjaan, dan tanggal masuk harus diisi!",
			});
			return;
		}

		$.ajax({
			url: url,
			type: "POST",
			data: filteredFormData,
			dataType: "json",
			beforeSend: function () {
				console.log("AJAX request starting...");
			},
			success: function (response) {
				console.log("AJAX response:", response);
				if (response.status) {
					$("#job-form-container").hide();
					Swal.fire({
						icon: "success",
						title: "Success",
						text: response.message,
					});

					loadJobHistoryForUser(currentUserId);

					if (window.userTable) {
						window.userTable.ajax.reload();
					}
				} else {
					console.error("Server returned error:", response.message);
					Swal.fire({
						icon: "error",
						title: "Error",
						text: response.message,
					});
				}
			},
			error: function (xhr, status, error) {
				console.error("AJAX Error:", {
					status: status,
					error: error,
					responseText: xhr.responseText,
					statusCode: xhr.status,
				});

				let errorMessage = "Terjadi kesalahan saat menyimpan data.";
				if (xhr.responseText) {
					try {
						const errorResponse = JSON.parse(xhr.responseText);
						errorMessage = errorResponse.message || errorMessage;
					} catch (e) {
						errorMessage += " Response: " + xhr.responseText.substring(0, 200);
					}
				}

				Swal.fire({
					icon: "error",
					title: "Error",
					text: errorMessage,
				});
			},
		});
	});

	// Delete job history
	$(document).on("click", ".delete-job-btn", function () {
		const jobId = $(this).data("id");
		const companyName = $(this).data("company");

		Swal.fire({
			title: "Hapus Riwayat Pekerjaan",
			text: `Apakah Anda yakin ingin menghapus riwayat pekerjaan di "${companyName}"?`,
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ya, Hapus",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: BASE_URL + "riwayat_pekerjaan/delete_job_history",
					type: "POST",
					data: { id: jobId },
					dataType: "json",
					success: function (response) {
						if (response.status) {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: response.message,
							});

							loadJobHistoryForUser(currentUserId);
						} else {
							Swal.fire({
								icon: "error",
								title: "Error",
								text: response.message,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: "error",
							title: "Error",
							text: "Terjadi kesalahan saat menghapus data.",
						});
					},
				});
			}
		});
	});
}

// Modal event handlers
function initModalEventHandlers() {
	console.log("Initializing modal event handlers");

	$("#modalDetailRiwayat").on("hidden.bs.modal", function () {
		$("#job-form-container").hide();
		$("#jobHistoryForm")[0].reset();
		$("#job_id").val("");
		$("#job-history-list").empty();
		window.currentUserId = null;
		currentUserId = null;
	});

	$("#modalDetailRiwayat").on("shown.bs.modal", function () {
		$(".job-detail-date-picker").datepicker({
			format: "dd.mm.yyyy",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom",
		});
	});
}

// Helper Functions
function loadRoles() {
	$.ajax({
		url: BASE_URL + "user_registration/get_roles_ajax",
		type: "POST",
		dataType: "json",
		success: function (response) {
			if (response.status && response.data) {
				var roleOptions = '<option value="">Select Role</option>';
				$.each(response.data, function (index, role) {
					roleOptions +=
						'<option value="' + role.id + '">' + role.role_name + "</option>";
				});
				$("#add_role").html(roleOptions);
				$("#edit_role").html(roleOptions);
			} else {
				$("#add_role").html('<option value="">No roles available</option>');
				$("#edit_role").html('<option value="">No roles available</option>');
			}
		},
		error: function () {
			console.log("Error loading roles");
			$("#add_role").html('<option value="">Error loading roles</option>');
			$("#edit_role").html('<option value="">Error loading roles</option>');
		},
	});
}

function loadDepartments() {
	$.ajax({
		url: BASE_URL + "user_registration/get_departments_ajax",
		type: "POST",
		dataType: "json",
		success: function (response) {
			if (response.status && response.data) {
				var departmentOptions = '<option value="">Select Department</option>';
				$.each(response.data, function (index, department) {
					departmentOptions +=
						'<option value="' +
						department.id +
						'">' +
						department.department_name +
						" (" +
						department.department_code +
						")</option>";
				});
				$("#add_department").html(departmentOptions);
				$("#edit_department").html(departmentOptions);
			} else {
				$("#add_department").html(
					'<option value="">No departments available</option>'
				);
				$("#edit_department").html(
					'<option value="">No departments available</option>'
				);
			}
		},
		error: function () {
			console.log("Error loading departments");
			$("#add_department").html(
				'<option value="">Error loading departments</option>'
			);
			$("#edit_department").html(
				'<option value="">Error loading departments</option>'
			);
		},
	});
}

// Function menampilkan riwayat pekerjaan
function displayJobHistory(jobHistory) {
	let jobHistoryHtml = "";

	if (jobHistory && jobHistory.length > 0) {
		jobHistory.forEach(function (job) {
			jobHistoryHtml += `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="card-title">${
																	job.namaperusahaan
																}</h6>
                                <p class="card-text">
                                    <strong>Posisi:</strong> ${
																			job.titlepekerjaan
																		}<br>
                                    <strong>Periode:</strong> ${
																			job.tanggalmasuk
																		} - ${job.tanggalkeluar || "Sekarang"}<br>
                                    <strong>Pendidikan:</strong> ${
																			job.universitas || "-"
																		}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-warning btn-sm edit-job-btn" data-job='${JSON.stringify(
																	job
																)}'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm delete-job-btn" data-id="${
																	job.id
																}" data-company="${job.namaperusahaan}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
		});
	} else {
		jobHistoryHtml =
			'<div class="alert alert-info">Belum ada riwayat pekerjaan.</div>';
	}

	$("#job-history-list").html(jobHistoryHtml);
}

function loadJobHistoryForUser(userId) {
	$.getJSON(
		BASE_URL + "riwayat_pekerjaan/get_user_with_history/" + userId,
		function (res) {
			displayJobHistory(res.riwayat);
		}
	).fail(function () {
		console.error("Failed to load job history");
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Gagal memuat riwayat pekerjaan",
		});
	});
}
