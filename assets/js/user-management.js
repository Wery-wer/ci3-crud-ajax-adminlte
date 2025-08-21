/**
 * User Management JavaScript
 * Handles user management functionality including CRUD operations, DataTable management, and auto-refresh
 */

// Global variables
let usersTable;
let autoRefreshInterval;
let isEditMode = false;
let editUserId = null;
let currentPage = 1;
let isUserActive = false;
let lastUserActivity = Date.now();

// Main initialization function
document.addEventListener("DOMContentLoaded", function () {
	if (typeof jQuery === "undefined") {
		setTimeout(function () {
			initUsersPage();
		}, 100);
	} else {
		initUsersPage();
	}
});

function initUsersPage() {
	$(document).ready(function () {
		// Initialize everything
		initializeDataTable();
		trackUserActivity();
		loadUsers();
		startAutoRefresh();
		initEventHandlers();
	});
}

// Initialize DataTable
function initializeDataTable() {
	usersTable = $("#usersTable").DataTable({
		responsive: {
			details: {
				type: "column",
				target: "tr",
			},
		},
		columnDefs: [
			{
				className: "control",
				orderable: false,
				targets: 0,
				responsivePriority: 1,
			},
			{
				responsivePriority: 1,
				targets: 1,
			},
			{
				responsivePriority: 2,
				targets: 2,
			},
			{
				responsivePriority: 3,
				targets: 3,
			},
			{
				responsivePriority: 4,
				targets: 4,
			},
			{
				responsivePriority: 1,
				targets: -1,
				orderable: false,
			},
		],
		order: [[4, "desc"]],
		pageLength: 10,
		lengthMenu: [
			[5, 10, 25, 50, -1],
			[5, 10, 25, 50, "All"],
		],
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
				previous: "Previous",
			},
		},
		drawCallback: function (settings) {
			currentPage = this.api().page.info().page + 1;
			updateRefreshStatus(autoRefreshInterval !== null, currentPage);
		},
	});

	// Track page changes
	usersTable.on("page.dt", function () {
		setTimeout(function () {
			currentPage = usersTable.page.info().page + 1;
			updateRefreshStatus(autoRefreshInterval !== null, currentPage);
		}, 100);
	});
}

// Initialize event handlers
function initEventHandlers() {
	// Form submission
	$("#userForm").on("submit", function (e) {
		e.preventDefault();

		const url = isEditMode
			? BASE_URL + "user_management/update_user_ajax"
			: BASE_URL + "user_management/create_user_ajax";

		const formData = {
			name: $("#name").val().trim(),
			email: $("#email").val().trim(),
		};

		if (isEditMode) {
			formData.id = editUserId;
		}

		showLoading();

		$.ajax({
			url: url,
			method: "POST",
			data: formData,
			dataType: "json",
			success: function (response) {
				hideLoading();

				if (response.success) {
					$("#userModal").modal("hide");

					Swal.fire({
						title: "Success!",
						text: response.message,
						icon: "success",
						timer: 1500,
						showConfirmButton: false,
					});

					loadUsers();
				} else {
					showAlert(response.message, "danger");
				}
			},
			error: function () {
				hideLoading();
				showAlert("Network error occurred. Please try again.", "danger");
			},
		});
	});

	// Modal events
	$("#userModal").on("shown.bs.modal", function () {
		stopAutoRefresh();
		$("#name").focus();
	});

	$("#userModal").on("hidden.bs.modal", function () {
		startAutoRefresh();
	});

	// Handle sidebar toggle untuk responsive DataTables
	$(document).on("click", '[data-widget="pushmenu"]', function () {
		setTimeout(function () {
			usersTable.columns.adjust();
			usersTable.responsive.recalc();
			$(window).trigger("resize");
		}, 350);
	});

	// Handle window resize
	$(window).on("resize", function () {
		clearTimeout(window.resizeTimer);
		window.resizeTimer = setTimeout(function () {
			usersTable.columns.adjust();
			usersTable.responsive.recalc();
		}, 250);
	});
}

// Track user activity
function trackUserActivity() {
	$(document).on("mousedown keydown scroll touchstart", function () {
		isUserActive = true;
		lastUserActivity = Date.now();
	});

	// Reset user activity after 2 seconds of inactivity
	setInterval(function () {
		if (Date.now() - lastUserActivity > 2000) {
			isUserActive = false;
		}
	}, 1000);
}

// Load users data
function loadUsers() {
	$.ajax({
		url: BASE_URL + "user_management/get_users_ajax",
		method: "GET",
		dataType: "json",
		success: function (response) {
			if (response.success) {
				populateTable(response.data);
			}
		},
		error: function (xhr, status, error) {
			console.error("Error loading users:", error);
			showAlert("Error loading users data. Please refresh the page.", "danger");
		},
	});
}

// Populate table with data
function populateTable(users) {
	usersTable.clear();

	users.forEach(function (user, index) {
		usersTable.row.add([
			index + 1,
			escapeHtml(user.name),
			escapeHtml(user.email),
			user.department_name
				? `<span class="badge badge-info">${escapeHtml(
						user.department_name
				  )}</span><br><small class="text-muted">${escapeHtml(
						user.department_code || ""
				  )}</small>`
				: '<span class="badge badge-secondary">No Department</span>',
			formatDate(user.created_at),
			`<div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>`,
		]);
	});

	usersTable.draw();
}

// Auto refresh functionality
function startAutoRefresh() {
	// Only auto-refresh on page 1 and when user is not actively interacting
	autoRefreshInterval = setInterval(function () {
		if (
			currentPage === 1 &&
			!isUserActive &&
			!$("#userModal").hasClass("show")
		) {
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

// Update refresh status (placeholder - implement if needed)
function updateRefreshStatus(isActive, page) {
	// This function can be implemented to show refresh status in UI
	console.log(`Auto-refresh: ${isActive ? "ON" : "OFF"}, Page: ${page}`);
}

// Loading state functions (placeholder - implement if needed)
function showLoading() {
	// Implement loading indicator
	console.log("Loading...");
}

function hideLoading() {
	// Hide loading indicator
	console.log("Loading complete");
}

// Manual refresh function
window.refreshUsersManual = function () {
	showLoading();
	loadUsers();
	setTimeout(hideLoading, 500);
	showAlert("Data refreshed successfully!", "success", 2000);
};

// Modal functions
window.openCreateModal = function () {
	isEditMode = false;
	editUserId = null;
	$("#userForm")[0].reset();
	$("#modal-title").text("Add New User");
	$("#save-text").text("Save User");
	$("#userModalLabel i").attr("class", "fas fa-user-plus");
};

window.editUser = function (id) {
	isEditMode = true;
	editUserId = id;

	showLoading();

	$.ajax({
		url: BASE_URL + "user_management/get_users_ajax",
		method: "GET",
		dataType: "json",
		success: function (response) {
			hideLoading();

			if (response.success) {
				const user = response.data.find((u) => u.id == id);
				if (user) {
					$("#name").val(user.name);
					$("#email").val(user.email);
					$("#save-text").text("Update User");
					$("#userModalLabel i").attr("class", "fas fa-user-edit");
					$("#userModal").modal("show");
				}
			}
		},
		error: function () {
			hideLoading();
			showAlert("Error loading user data!", "danger");
		},
	});
};

window.deleteUser = function (id) {
	Swal.fire({
		title: "Delete User?",
		text: "This action cannot be undone!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#dc3545",
		cancelButtonColor: "#6c757d",
		confirmButtonText: "Yes, Delete!",
		cancelButtonText: "Cancel",
	}).then((result) => {
		if (result.isConfirmed) {
			showLoading();

			$.ajax({
				url: BASE_URL + "user_management/delete_user_ajax",
				method: "POST",
				data: { id: id },
				dataType: "json",
				success: function (response) {
					hideLoading();

					if (response.success) {
						Swal.fire({
							title: "Deleted!",
							text: "User has been deleted successfully.",
							icon: "success",
							timer: 1500,
							showConfirmButton: false,
						});
						loadUsers();
					} else {
						Swal.fire({
							title: "Error!",
							text: response.message || "Failed to delete user.",
							icon: "error",
							confirmButtonColor: "#dc3545",
						});
					}
				},
				error: function () {
					hideLoading();
					Swal.fire({
						title: "Error!",
						text: "Network error occurred while deleting user.",
						icon: "error",
						confirmButtonColor: "#dc3545",
					});
				},
			});
		}
	});
};

// Utility functions
function showAlert(message, type, duration = 5000) {
	const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${
							type === "success"
								? "check-circle"
								: type === "danger"
								? "exclamation-triangle"
								: "info-circle"
						}"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

	$("#alert-container").html(alertHtml);

	if (duration > 0) {
		setTimeout(function () {
			$("#alert-container .alert").fadeOut();
		}, duration);
	}
}

function escapeHtml(text) {
	const map = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': "&quot;",
		"'": "&#039;",
	};
	return text.replace(/[&<>"']/g, function (m) {
		return map[m];
	});
}

function formatDate(dateString) {
	const date = new Date(dateString);
	return date.toLocaleString("id-ID", {
		year: "numeric",
		month: "short",
		day: "2-digit",
		hour: "2-digit",
		minute: "2-digit",
		timeZone: "Asia/Jakarta",
	});
}
