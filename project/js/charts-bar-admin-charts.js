var completedLessonsPerDay;

var completedLessonsChartElement = document.getElementById(
	"completed_lessons_chart"
);

if (completedLessonsChartElement) {
	completedLessonsPerDay = JSON.parse(
		completedLessonsChartElement.getAttribute("data-completed_lessons_per_day")
	);
	var allValuesNull = Object.values(completedLessonsPerDay).every(
		(value) => value === null || value === 0
	);

	if (!allValuesNull) {
		Chart.defaults.global.defaultFontFamily =
			'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = "#292b2c";

		var completedLessonsLabels = Object.keys(completedLessonsPerDay).map(
			(day) => {
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
			}
		);

		var completedLessonsDataValues = Object.values(completedLessonsPerDay);
		var completedLessonsMaxYValue = Math.max(...completedLessonsDataValues);

		var completedLessonsCtx = document.getElementById(
			"completed_lessons_chart"
		);

		var completedLessonsBarChart = new Chart(completedLessonsCtx, {
			type: "bar",
			data: {
				labels: completedLessonsLabels,
				datasets: [
					{
						label: "Completed Lessons",
						backgroundColor: "rgba(2,117,216,1)",
						borderColor: "rgba(2,117,216,1)",
						data: completedLessonsDataValues,
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
								maxTicksLimit: 6,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								min: 0,
								max: completedLessonsMaxYValue,
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
	} else {
		console.log(
			"All values in completedLessonsPerDay are null. No chart will be rendered."
		);
		completedLessonsChartElement.parentElement.innerHTML =
			"<p>No data available for completed lessons.</p>";
	}
}

var completedCoursesPerDay;

var completedCoursesChartElement = document.getElementById(
	"completed_courses_chart"
);

if (completedCoursesChartElement) {
	completedCoursesPerDay = JSON.parse(
		completedCoursesChartElement.getAttribute("data-completed_courses_per_day")
	);
	var allValuesNull = Object.values(completedCoursesPerDay).every(
		(value) => value === null || value === 0
	);

	if (!allValuesNull) {
		Chart.defaults.global.defaultFontFamily =
			'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = "#292b2c";

		var completedCoursesLabels = Object.keys(completedCoursesPerDay).map(
			(day) => {
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
			}
		);

		var completedCoursesDataValues = Object.values(completedCoursesPerDay);
		var completedCoursesMaxYValue = Math.max(...completedCoursesDataValues);

		var completedCoursesCtx = document.getElementById(
			"completed_courses_chart"
		);

		var completedCoursesBarChart = new Chart(completedCoursesCtx, {
			type: "bar",
			data: {
				labels: completedCoursesLabels,
				datasets: [
					{
						label: "Completed Courses",
						backgroundColor: "rgba(2,117,216,1)",
						borderColor: "rgba(2,117,216,1)",
						data: completedCoursesDataValues,
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
								maxTicksLimit: 6,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								min: 0,
								max: completedCoursesMaxYValue,
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
	} else {
		console.log(
			"All values in completedCoursesPerDay are null. No chart will be rendered."
		);
		completedCoursesChartElement.parentElement.innerHTML =
			"<p>No data available for completed courses.</p>";
	}
}

var avarageCompletionTimePerMonth;

var avarageCompletionTimeChartElement = document.getElementById(
	"avarage_completion_time_chart"
);

if (avarageCompletionTimeChartElement) {
	avarageCompletionTimePerMonth = JSON.parse(
		avarageCompletionTimeChartElement.getAttribute(
			"data-average_completion_time_per_month"
		)
	);
	var allValuesNull = Object.values(avarageCompletionTimePerMonth).every(
		(value) => value === null || value === 0
	);

	if (!allValuesNull) {
		Chart.defaults.global.defaultFontFamily =
			'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = "#292b2c";

		var avarageCompletionTimeLabels = Object.keys(
			avarageCompletionTimePerMonth
		);

		var avarageCompletionTimeDataValues = Object.values(
			avarageCompletionTimePerMonth
		);
		var avarageCompletionTimeMaxYValue = Math.max(
			...avarageCompletionTimeDataValues
		);

		var avarageCompletionTimeCtx = document.getElementById(
			"avarage_completion_time_chart"
		);

		var avarageCompletionTimeBarChart = new Chart(avarageCompletionTimeCtx, {
			type: "bar",
			data: {
				labels: avarageCompletionTimeLabels,
				datasets: [
					{
						label: "Average Completion Time (days)",
						backgroundColor: "rgba(2,117,216,1)",
						borderColor: "rgba(2,117,216,1)",
						data: avarageCompletionTimeDataValues,
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
								maxTicksLimit: 6,
							},
						},
					],
					yAxes: [
						{
							ticks: {
								min: 0,
								max: avarageCompletionTimeMaxYValue,
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
	} else {
		console.log(
			"All values in averageCompletionTimePerMonth are null. No chart will be rendered."
		);
		averageCompletionTimeChartElement.parentElement.innerHTML =
			"<p>No data available for average completion time.</p>";
	}
}
