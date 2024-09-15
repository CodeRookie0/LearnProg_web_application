var newUsersPerDay;

var newUsersChartElement = document.getElementById("new_users_chart");

if (newUsersChartElement) {
	newUsersPerDay = JSON.parse(
		newUsersChartElement.getAttribute("data-new-users-per-day")
	);
	var allValuesNull = Object.values(newUsersPerDay).every(
		(value) => value === null || value === 0
	);

	if (!allValuesNull) {
		Chart.defaults.global.defaultFontFamily =
			'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = "#292b2c";

		var newUsersLabels = Object.keys(newUsersPerDay).map((day) => {
			var monthNames = [
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec",
			];

			var today = new Date();
			var monthIndex = today.getMonth();
			var monthName = monthNames[monthIndex];

			return monthName + " " + day;
		});

		var newUsersDataValues = Object.values(newUsersPerDay);
		var newUsersMaxYValue = Math.max(...newUsersDataValues);

		var newUsersCtx = document.getElementById("new_users_chart");

		var newUsersLineChart = new Chart(newUsersCtx, {
			type: "line",
			data: {
				labels: newUsersLabels,
				datasets: [
					{
						label: "New User Registrations",
						lineTension: 0.3,
						backgroundColor: "rgba(2,117,216,0.2)",
						borderColor: "rgba(2,117,216,1)",
						pointRadius: 5,
						pointBackgroundColor: "rgba(2,117,216,1)",
						pointBorderColor: "rgba(255,255,255,0.8)",
						pointHoverRadius: 5,
						pointHoverBackgroundColor: "rgba(2,117,216,1)",
						pointHitRadius: 50,
						pointBorderWidth: 2,
						data: newUsersDataValues,
					},
				],
			},
			options: {
				scales: {
					xAxes: [
						{
							time: {
								unit: "date",
							},
							gridLines: {
								display: false,
							},
							ticks: {
								maxTicksLimit: 7,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								min: 0,
								max: newUsersMaxYValue,
								maxTicksLimit: 5,
								callback: function (value, index, values) {
									return Number.isInteger(value) ? value : "";
								},
							},
							gridLines: {
								color: "rgba(0, 0, 0, .125)",
							},
						},
					],
				},
				legend: {
					display: false,
				},
			},
		});
	}
}

var activeUsersPerDay;

var activeUsersChartElement = document.getElementById("active_users_chart");

if (activeUsersChartElement) {
	activeUsersPerDay = JSON.parse(
		activeUsersChartElement.getAttribute("data-active_users_per_day")
	);
	var allValuesNull = Object.values(activeUsersPerDay).every(
		(value) => value === null || value === 0
	);

	if (!allValuesNull) {
		Chart.defaults.global.defaultFontFamily =
			'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = "#292b2c";

		var activeUsersLabels = Object.keys(activeUsersPerDay).map((day) => {
			var monthNames = [
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec",
			];

			var today = new Date();
			var monthIndex = today.getMonth();
			var monthName = monthNames[monthIndex];

			return monthName + " " + day;
		});

		var activeUsersDataValues = Object.values(activeUsersPerDay);
		var activeUsersMaxYValue = Math.max(...activeUsersDataValues);

		var activeUsersCtx = document.getElementById("active_users_chart");

		var activeUsersLineChart = new Chart(activeUsersCtx, {
			type: "line",
			data: {
				labels: activeUsersLabels,
				datasets: [
					{
						label: "Users active on this day",
						lineTension: 0.3,
						backgroundColor: "rgba(2,117,216,0.2)",
						borderColor: "rgba(2,117,216,1)",
						pointRadius: 5,
						pointBackgroundColor: "rgba(2,117,216,1)",
						pointBorderColor: "rgba(255,255,255,0.8)",
						pointHoverRadius: 5,
						pointHoverBackgroundColor: "rgba(2,117,216,1)",
						pointHitRadius: 50,
						pointBorderWidth: 2,
						data: activeUsersDataValues,
					},
				],
			},
			options: {
				scales: {
					xAxes: [
						{
							time: {
								unit: "date",
							},
							gridLines: {
								display: false,
							},
							ticks: {
								maxTicksLimit: 7,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								min: 0,
								max: activeUsersMaxYValue,
								maxTicksLimit: 5,
								callback: function (value, index, values) {
									return Number.isInteger(value) ? value : "";
								},
							},
							gridLines: {
								color: "rgba(0, 0, 0, .125)",
							},
						},
					],
				},
				legend: {
					display: false,
				},
			},
		});
	}
}
