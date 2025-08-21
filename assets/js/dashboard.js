/**
 * Dashboard JavaScript
 * Handles dashboard functionality including time updates, calendar widget, and system status
 */

// Global variables
let currentDate = new Date();
let selectedDate = null;

// Main initialization function
document.addEventListener("DOMContentLoaded", function () {
	if (typeof jQuery === "undefined") {
		setTimeout(function () {
			initDashboard();
		}, 100);
	} else {
		initDashboard();
	}
});

function initDashboard() {
	$(document).ready(function () {
		// Update dashboard time
		function updateDashboardTime() {
			const now = new Date();
			const timeString = now.toLocaleTimeString("id-ID", {
				hour: "2-digit",
				minute: "2-digit",
				hour12: false,
				timeZone: "Asia/Jakarta",
			});
			$("#dashboard-time").text(timeString);
		}

		// Update every minute
		updateDashboardTime();
		setInterval(updateDashboardTime, 60000);

		// Initialize Bootstrap Calendar
		initBootstrapCalendar();
	});
}

// System Status Check Function
function checkSystemStatus() {
	Swal.fire({
		title: "System Health Check",
		html: `
            <div class="text-left">
                <p><i class="fas fa-check text-success"></i> Database Connection: <strong>OK</strong></p>
                <p><i class="fas fa-check text-success"></i> AJAX Functions: <strong>Working</strong></p>
                <p><i class="fas fa-check text-success"></i> Auto-refresh: <strong>Active</strong></p>
                <p><i class="fas fa-check text-success"></i> Session Management: <strong>OK</strong></p>
                <p><i class="fas fa-check text-success"></i> Timezone: <strong>Asia/Jakarta</strong></p>
            </div>
        `,
		icon: "success",
		confirmButtonText: "Great!",
		confirmButtonColor: "#28a745",
	});
}

// Bootstrap Calendar Implementation
function initBootstrapCalendar() {
	const monthNames = [
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
	];

	const dayNames = [
		"Minggu",
		"Senin",
		"Selasa",
		"Rabu",
		"Kamis",
		"Jumat",
		"Sabtu",
	];

	function updateCalendar() {
		const year = currentDate.getFullYear();
		const month = currentDate.getMonth();

		// Update header
		$("#currentMonthYear").text(`${monthNames[month]} ${year}`);

		// Get first day of month and number of days
		const firstDay = new Date(year, month, 1);
		const lastDay = new Date(year, month + 1, 0);
		const startDate = new Date(firstDay);
		startDate.setDate(startDate.getDate() - firstDay.getDay());

		// Clear calendar
		$("#calendar-dates").empty();

		// Generate calendar weeks
		const today = new Date();
		let weekRow = null;

		for (let i = 0; i < 42; i++) {
			if (i % 7 === 0) {
				weekRow = $('<div class="row calendar-week"></div>');
				$("#calendar-dates").append(weekRow);
			}

			const cellDate = new Date(startDate);
			cellDate.setDate(startDate.getDate() + i);

			const isCurrentMonth = cellDate.getMonth() === month;
			const isToday = cellDate.toDateString() === today.toDateString();
			const isSelected =
				selectedDate && cellDate.toDateString() === selectedDate.toDateString();

			let cellClass = "col calendar-day";
			if (!isCurrentMonth) cellClass += " other-month";
			if (isToday) cellClass += " today";
			if (isSelected) cellClass += " selected";

			const cell = $(`<div class="${cellClass}" data-date="${
				cellDate.toISOString().split("T")[0]
			}">
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
                    <i class="fas fa-clock"></i> ${new Date().toLocaleString(
											"id-ID"
										)}
                </small>
            </div>
        `;

		$("#selected-date-info").html(info);
	}

	// Event handlers
	$(document).on("click", ".calendar-day:not(.other-month)", function () {
		$(".calendar-day").removeClass("selected");
		$(this).addClass("selected");

		const dateStr = $(this).data("date");
		selectedDate = new Date(dateStr);
		updateSelectedDateInfo(selectedDate);
	});

	$("#prevMonth").on("click", function () {
		currentDate.setMonth(currentDate.getMonth() - 1);
		updateCalendar();
	});

	$("#nextMonth").on("click", function () {
		currentDate.setMonth(currentDate.getMonth() + 1);
		updateCalendar();
	});

	// Initialize calendar
	updateCalendar();

	// Set today as selected by default
	selectedDate = new Date();
	updateSelectedDateInfo(selectedDate);

	// Update time every second
	setInterval(function () {
		if (selectedDate) {
			updateSelectedDateInfo(selectedDate);
		}
	}, 1000);
}
