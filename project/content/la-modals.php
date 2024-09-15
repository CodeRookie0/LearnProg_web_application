<div class="modal" id="addLessonModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLessonForm">
                    <div class="mb-3">
                        <label for="courseId" class="form-label">Course Id</label>
                        <input type="text" class="form-control" id="courseId" name="courseId" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order" required>
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" id="points" name="points" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <div class="input-group">
                            <select class="form-select" id="content" name="content" required>
                                <option value="header3">Header 3</option>
                                <option value="header4">Header 4</option>
                                <option value="paragraph" selected>Paragraph</option>
                                <option value="orderedlist">Ordered list</option>
                                <option value="unorderedlist">Unordered list</option>
                                <option value="warning">Warning</option>
                                <option value="image">Image</option>
                            </select>
                            <button type="button" class="btn btn-secondary" id="addContentBtn" onclick="addInput()">Add</button>
                        </div>
                    </div>
                    <div class="mb-3" id="contentContainer">
                        <!-- Content added dynamically here -->
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editLessonModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLessonForm">
                    <input type="hidden" id="editLessonId" name="editLessonId">
                    <div class="mb-3">
                        <label for="editLessonCourseId" class="form-label">Course Id</label>
                        <input type="text" class="form-control" id="editLessonCourseId" name="editLessonCourseId" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="editOrder" class="form-label">Order</label>
                        <input type="number" class="form-control" id="editOrder" name="editOrder" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPoints" class="form-label">Points</label>
                        <input type="number" class="form-control" id="editPoints" name="editPoints" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">Content</label>
                        <textarea class="form-control" rows="10" id="editContent" name="editContent" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addLessonFileModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lesson File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLessonFileForm">
                    <div class="mb-3">
                        <label for="lessonId" class="form-label">Lesson Id</label>
                        <input type="text" class="form-control" id="lessonId" name="lessonId" required>
                    </div>
                    <div class="mb-3">
                        <label for="fileName" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="fileName" name="fileName" required>
                    </div>
                    <div class="mb-3">
                        <label for="altText" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="altText" name="altText" required>
                    </div>
                    <div class="mb-3">
                        <label for="filePath" class="form-label">File Path</label>
                        <input type="text" class="form-control" id="filePath" name="filePath" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editLessonFileModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Lesson File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLessonFileForm">
                    <input type="hidden" id="editLessonFileId" name="editLessonFileId">
                    <div class="mb-3">
                        <label for="editFileLessonId" class="form-label">Lesson Id</label>
                        <input type="text" class="form-control" id="editFileLessonId" name="editFileLessonId" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFileName" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="editFileName" name="editFileName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAltText" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="editAltText" name="editAltText" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFilePath" class="form-label">File Path</label>
                        <input type="text" class="form-control" id="editFilePath" name="editFilePath" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addTaskModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm">
                    <div class="mb-3">
                        <label for="taskLessonId" class="form-label">Lesson Id</label>
                        <input type="text" class="form-control" id="taskLessonId" name="taskLessonId" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskType" class="form-label">Type</label>
                        <select class="form-select" id="taskType" name="taskType" required>
                            <?php foreach ($task_types as $task_type) { ?>
                                <option value="<?php echo $task_type['id']; ?>">
                                <?php echo $task_type['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" required placeholder="Write the content of the task here"></textarea>
                    </div>
                    <div class="mb-3" id="optionsContainer">
                        <label for="taskOptions" class="form-label">Options</label>
                        <input type="text" class="form-control" id="taskOptions" name="taskOptions" placeholder="Separate options with ';' if applicable">
                    </div>
                    <div class="mb-3">
                        <label for="taskSolution" class="form-label">Solution</label>
                        <input type="text" class="form-control" id="taskSolution" name="taskSolution" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editTaskModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="editTaskId" name="editTaskId">
                    <div class="mb-3">
                        <label for="editTaskLessonId" class="form-label">Lesson Id</label>
                        <input type="text" class="form-control" id="editTaskLessonId" name="editTaskLessonId" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskType" class="form-label">Type</label>
                        <select class="form-select" id="editTaskType" name="editTaskType" required>
                            <?php foreach ($task_types as $task_type) { ?>
                                <option value="<?php echo $task_type['id']; ?>">
                                <?php echo $task_type['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editTaskDescription" name="editTaskDescription" rows="3" required placeholder="Write the content of the task here"></textarea>
                    </div>
                    <div class="mb-3" id="editOptionsContainer">
                        <label for="editTaskOptions" class="form-label">Options</label>
                        <input type="text" class="form-control" id="editTaskOptions" name="editTaskOptions" placeholder="Separate options with ';' if applicable">
                    </div>
                    <div class="mb-3">
                        <label for="editTaskSolution" class="form-label">Solution</label>
                        <input type="text" class="form-control" id="editTaskSolution" name="editTaskSolution" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>