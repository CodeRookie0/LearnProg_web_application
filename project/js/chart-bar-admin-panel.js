var completedLessonsPerDay;

var completedLessonsChartElement = document.getElementById(
	"completed_lessons_chart"
);

if (completedLessonsChartElement) {
    completedLessonsPerDay = JSON.parse(
		completedLessonsChartElement.getAttribute("data-completed-lessons-per-day")
	);
    var allValuesNull = Object.values(completedLessonsPerDay).every(
		(value) => value === null|| value === 0
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