/**
 * Profile JavaScript
 * Handles profile functionality including profile updates and form validation
 */

// Main initialization function
document.addEventListener("DOMContentLoaded", function () {
	if (typeof jQuery === "undefined") {
		setTimeout(function () {
			initProfile();
		}, 100);
	} else {
		initProfile();
	}
});

function initProfile() {
	$(document).ready(function () {
		// Initialize profile form submission
		initProfileForm();

		// Initialize other profile-related functionality
		initProfileActivityLog();
	});
}

// Initialize profile form functionality
function initProfileForm() {
	$("#editProfileForm").on("submit", function (e) {
		e.preventDefault();

		var formData = $(this).serialize();
		var submitBtn = $(this).find('button[type="submit"]');

		// Show loading state
		submitBtn.prop("disabled", true).text("Updating...");

		$.ajax({
			url: BASE_URL + "profile/update_profile_ajax",
			type: "POST",
			data: formData,
			dataType: "json",
			success: function (response) {
				if (response.success) {
					Swal.fire({
						icon: "success",
						title: "Success!",
						text: response.message,
					}).then(function () {
						// Reload page to show updated information
						window.location.reload();
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Error!",
						html: response.message,
					});
				}
			},
			error: function (xhr, status, error) {
				console.error("Profile update error:", error);
				Swal.fire({
					icon: "error",
					title: "Error!",
					text: "Something went wrong! Please try again.",
				});
			},
			complete: function () {
				// Reset button state
				submitBtn.prop("disabled", false).text("Update Profile");
			},
		});
	});

	// Form validation
	$("#editProfileForm input[required]").on("blur", function () {
		validateField($(this));
	});

	// Password strength indicator
	$("#edit_password").on("input", function () {
		checkPasswordStrength($(this).val());
	});
}

// Initialize profile activity log functionality
function initProfileActivityLog() {
	// Add real-time clock to activity timeline
	updateActivityTime();
	setInterval(updateActivityTime, 1000);

	// Log profile view activity
	logActivity("profile_view", "Profile page accessed");
}

// Form validation helper
function validateField($field) {
	const value = $field.val().trim();
	const fieldName = $field.attr("name");
	let isValid = true;
	let message = "";

	// Remove existing validation feedback
	$field.removeClass("is-invalid is-valid");
	$field.siblings(".invalid-feedback").remove();

	if ($field.prop("required") && !value) {
		isValid = false;
		message = "This field is required";
	} else if (fieldName === "email" && value) {
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!emailRegex.test(value)) {
			isValid = false;
			message = "Please enter a valid email address";
		}
	} else if (fieldName === "username" && value) {
		if (value.length < 3) {
			isValid = false;
			message = "Username must be at least 3 characters long";
		}
	}

	if (isValid) {
		$field.addClass("is-valid");
	} else {
		$field.addClass("is-invalid");
		$field.after(`<div class="invalid-feedback">${message}</div>`);
	}

	return isValid;
}

// Password strength checker
function checkPasswordStrength(password) {
	const $passwordField = $("#edit_password");
	const $strengthIndicator = $("#password-strength");

	// Remove existing strength indicator
	$strengthIndicator.remove();

	if (!password) return;

	let strength = 0;
	let strengthText = "";
	let strengthClass = "";

	// Check password criteria
	if (password.length >= 8) strength++;
	if (/[a-z]/.test(password)) strength++;
	if (/[A-Z]/.test(password)) strength++;
	if (/[0-9]/.test(password)) strength++;
	if (/[^A-Za-z0-9]/.test(password)) strength++;

	// Determine strength level
	switch (strength) {
		case 0:
		case 1:
			strengthText = "Very Weak";
			strengthClass = "text-danger";
			break;
		case 2:
			strengthText = "Weak";
			strengthClass = "text-warning";
			break;
		case 3:
			strengthText = "Fair";
			strengthClass = "text-info";
			break;
		case 4:
			strengthText = "Good";
			strengthClass = "text-primary";
			break;
		case 5:
			strengthText = "Strong";
			strengthClass = "text-success";
			break;
	}

	// Show strength indicator
	const strengthIndicator = `
        <div id="password-strength" class="mt-1">
            <small class="${strengthClass}">
                <i class="fas fa-shield-alt"></i> Password strength: ${strengthText}
            </small>
        </div>
    `;

	$passwordField.after(strengthIndicator);
}

// Update activity timeline time
function updateActivityTime() {
	const now = new Date();
	const timeString = now.toLocaleTimeString("id-ID", {
		hour: "2-digit",
		minute: "2-digit",
		hour12: false,
		timeZone: "Asia/Jakarta",
	});

	// Update current time in activity log
	$(".timeline .time:first").html(`<i class="far fa-clock"></i> ${timeString}`);
}

// Log activity (placeholder for future implementation)
function logActivity(type, description) {
	console.log(
		`Activity logged: ${type} - ${description} at ${new Date().toISOString()}`
	);

	// In a real application, you might want to send this to the server
	// $.ajax({
	//     url: BASE_URL + "profile/log_activity",
	//     type: "POST",
	//     data: {
	//         type: type,
	//         description: description,
	//         timestamp: new Date().toISOString()
	//     }
	// });
}
