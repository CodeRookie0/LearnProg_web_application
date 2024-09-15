<div class="modal" id="addCourseModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm">
                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="courseName" name="courseName" required>
                    </div>
                    <div class="mb-3">
                        <label for="fullDescription" class="form-label">Full Description</label>
                        <textarea class="form-control" id="fullDescription" name="fullDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="shortDescription" class="form-label">Short Description</label>
                        <textarea class="form-control" id="shortDescription" name="shortDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="imagePath" class="form-label">Image Path</label>
                        <input type="text" class="form-control" id="imagePath" name="imagePath" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="editCourseModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm">
                    <input type="hidden" id="editCourseId" name="editCourseId">
                    <div class="mb-3">
                        <label for="editCourseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="editCourseName" name="editCourseName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editShortDescription" class="form-label">Short Description</label>
                        <textarea class="form-control" id="editShortDescription" name="editShortDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editFullDescription" class="form-label">Full Description</label>
                        <textarea class="form-control" id="editFullDescription" name="editFullDescription" rows="7" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editLevel" class="form-label">Level</label>
                        <select class="form-select" id="editLevel" name="editLevel" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="editStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editImagePath" class="form-label">Image Path</label>
                        <input type="text" class="form-control" id="editImagePath" name="editImagePath" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal" id="addCourseTopicModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseTopicForm">
                    <div class="mb-3">
                        <label for="courseTopicId" class="form-label">Course Id</label>
                        <input type="text" class="form-control" id="courseTopicId" name="courseTopicId" required>
                    </div>
                    <div class="mb-3">
                        <label for="topicName" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="topicName" name="topicName" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="editCourseTopicModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseTopicForm">
                    <input type="hidden" id="editTopicId" name="editTopicId">
                    <div class="mb-3">
                        <label for="editCourseTopicId" class="form-label">Course Id</label>
                        <input type="text" class="form-control" id="editCourseTopicId" name="editCourseTopicId" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTopicName" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="editTopicName" name="editTopicName" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>