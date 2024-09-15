document.addEventListener("DOMContentLoaded", function () {
	fetchCoursesAndLessons();
	function fetchCoursesAndLessons() {
		$.ajax({
			url: "../actions/get-courses.php",
			method: "GET",
			success: function (response) {
				var courses = JSON.parse(response);
				var halfLength = Math.ceil(courses.length / 2);

				var coursesFirstHalf = courses.slice(0, halfLength);
				var coursesSecondHalf = courses.slice(halfLength);

				addCoursesToColumn(coursesFirstHalf, "courses-container-col1");
				addCoursesToColumn(coursesSecondHalf, "courses-container-col2");
			},
			error: function (xhr, status, error) {
				console.error("Błąd podczas pobierania kursów:", error);
			},
		});
	}

	function addCoursesToColumn(courses, columnId) {
		courses.forEach(function (course) {
			var courseId = course.id;

			var courseColumn = document.getElementById(columnId);

			var courseNameElement = document.createElement("h3");
			courseNameElement.className = "course-name mb-3";
			courseNameElement.textContent = course.name;
			courseColumn.appendChild(courseNameElement);

			var courseContainer = document.createElement("div");
			courseContainer.className =
				"course-container border rounded p-3 mb-3 bg-light";
			courseContainer.id = "course-" + courseId;
			courseColumn.appendChild(courseContainer);

			$.ajax({
				url: "../actions/get-lessons.php",
				method: "POST",
				data: { courseId: courseId },
				success: function (lessonResponse) {
					var lessons = JSON.parse(lessonResponse);

					lessons.sort(function(a, b) {
						return a.order - b.order;
					});
					
					lessons.forEach(function (lesson) {
						var lessonElement = document.createElement("div");
						lessonElement.className = "border rounded p-2 mb-2 bg-white";
						lessonElement.textContent = lesson.title;
						lessonElement.setAttribute("data-lesson-id", lesson.id);
						courseContainer.appendChild(lessonElement);
					});
					initSortable(courseContainer);
				},
				error: function (xhr, status, error) {
					console.error("Błąd podczas pobierania lekcji:", error);
				},
			});
		});
	}

	function initSortable(container) {
		new Sortable(container, {
			group: "shared",
			animation: 150,
			onEnd: function (evt) {
				var sourceCourseId = evt.from.id.replace("course-", "");
				var targetCourseId = evt.to.id.replace("course-", "");
				var lessonId = evt.item.getAttribute("data-lesson-id");

				moveLesson(evt, lessonId, sourceCourseId, targetCourseId);
			},
		});
	}

	function moveLesson(evt, lessonId, sourceCourseId, targetCourseId) {
		var targetCourseContainer = document.getElementById(
			"course-" + targetCourseId
		);
		var targetOrder =
			Array.from(targetCourseContainer.children).indexOf(evt.item) + 1;

		var confirmation = confirm(
			"Are you sure you want to transfer lesson ID " + lessonId + " ?"
		);
		if (confirmation) {
			$.ajax({
				url: "../actions/move-lesson.php",
				method: "POST",
				data: {
					lessonId: lessonId,
					sourceCourseId: sourceCourseId,
					targetCourseId: targetCourseId,
					targetOrder: targetOrder,
				},
				success: function (response) {
					var data = JSON.parse(response);
					if (data.status === "success") {
						alert(data.message);
						location.reload();
					} else if (data.status === "error") {
						alert("An error occurred while moving lesson: " + data.message);
					}
				},
				error: function (xhr, status, error) {
					alert("An error occurred while moving lesson: ", error);
				},
			});
		} else {
			console.log("Lesson transfer canceled.");
			location.reload();
		}
	}
});
