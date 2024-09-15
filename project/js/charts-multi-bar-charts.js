var courseEngagementChartElement = document.getElementById(
	"course_engagement_chart"
);
if (courseEngagementChartElement) {
	var courseEngagementData = JSON.parse(
		courseEngagementChartElement.getAttribute("data-course_engagement")
	);

	var courseIds = [];
	var courseNames = [];
	var totalUsersData = [];
	var incompleteUsersData = [];
	var completedUsersData = [];

	Object.keys(courseEngagementData).forEach(function (key) {
		var course = courseEngagementData[key];
		courseIds.push(course.course_id);
		courseNames.push(course.course_name);
		totalUsersData.push(course.total_users);
		incompleteUsersData.push(course.incomplete_users);
		completedUsersData.push(course.completed_users);
	});

	var allTotalUsersNull = totalUsersData.every(
		(value) => value === null || value === 0
	);
	var allIncompleteUsersNull = incompleteUsersData.every(
		(value) => value === null || value === 0
	);
	var allCompletedUsersNull = completedUsersData.every(
		(value) => value === null || value === 0
	);

	if (!allTotalUsersNull && !allIncompleteUsersNull && !allCompletedUsersNull) {
		var courseEngagementMaxYValue = Math.max(...totalUsersData);

		var ctx = document
			.getElementById("course_engagement_chart")
			.getContext("2d");
		var courseEngagementChart = new Chart(ctx, {
			type: "bar",
			data: {
				labels: courseIds,
				datasets: [
					{
						label: "Users Started Course",
						backgroundColor: "rgba(2,117,216,1)",
						borderColor: "rgba(2,117,216,1)",
						data: totalUsersData,
						barThickness: 20,
					},
					{
						label: "Users Completed Course",
						backgroundColor: "rgba(40,167,69,1)",
						borderColor: "rgba(40,167,69,1)",
						data: completedUsersData,
						stack: "Stack 1",
					},
					{
						label: "Users Not Completed Course",
						backgroundColor: "rgba(220, 53, 69, 1)",
						borderColor: "rgba(220, 53, 69, 1)",
						data: incompleteUsersData,
						stack: "Stack 1",
					},
				],
			},
			options: {
				scales: {
					xAxes: [
						{
							stacked: false,
							gridLines: {
								display: false,
							},
							ticks: {
								maxTicksLimit: 10,
							},
						},
					],
					yAxes: [
						{
							stacked: true,
							ticks: {
								min: 0,
								max: courseEngagementMaxYValue,
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
					display: true,
				},
				tooltips: {
					callbacks: {
						title: function (tooltipItems, data) {
							var index = tooltipItems[0].index;
							return courseNames[index];
						},
					},
				},
			},
		});
	} else {
		console.log(
			"All values in courseEngagementData are null. No chart will be rendered."
		);
		courseEngagementChartElement.parentElement.innerHTML =
			"<p>No data available for course engagement.</p>";
	}
}
