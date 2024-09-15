<div class="modal" id="addUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="userType" class="form-label">User Type</label>
                        <select class="form-select" id="userType" name="userType" required>
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="editUserId">
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="editUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editUserEmail" name="editUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserType" class="form-label">User Type</label>
                        <select class="form-select" id="editUserType" name="editUserType" required>
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserRegistrationDate" class="form-label">Registration Date</label>
                        <input type="date" class="form-control" id="editUserRegistrationDate" name="editUserRegistrationDate" required max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="text" class="form-control" id="editPassword" name="editUserPassword">
                    </div>
                    <div class="mb-3">
                        <label for="editPasswordConfirm" class="form-label">Confirm Password</label>
                        <input type="text" class="form-control" id="editPasswordConfirm" name="editUserPasswordConfirm">
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addUserCourseProgressModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User Course Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserCourseProgressForm">
                    <div class="mb-3">
                        <label for="userCourseUserId" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="userCourseUserId" name="userCourseUserId" required>
                    </div>
                    <div class="mb-3">
                        <label for="userCourseCourseId" class="form-label">Course ID</label>
                        <input type="number" class="form-control" id="userCourseCourseId" name="userCourseCourseId" required>
                    </div>
                    <div class="mb-3">
                        <label for="userCourseStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="userCourseStartDate" name="userCourseStartDate" required max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="userCourseCompletionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="userCourseCompletionDate" name="userCourseCompletionDate" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editUserCourseProgressModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Course Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserCourseProgressForm">
                    <div class="mb-3">
                        <label for="editUserCourseUserId" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="editUserCourseUserId" name="editUserCourseUserId" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editUserCourseCourseId" class="form-label">Course ID</label>
                        <input type="number" class="form-control" id="editUserCourseCourseId" name="editUserCourseCourseId" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editUserCourseStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="editUserCourseStartDate" name="editUserCourseStartDate" required max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="editUserCourseCompletionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="editUserCourseCompletionDate" name="editUserCourseCompletionDate" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addUserLessonProgressModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User Lesson Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserLessonProgressForm">
                    <div class="mb-3">
                        <label for="userLessonUserId" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="userLessonUserId" name="userLessonUserId" required>
                    </div>
                    <div class="mb-3">
                        <label for="userLessonLessonId" class="form-label">Lesson ID</label>
                        <input type="number" class="form-control" id="userLessonLessonId" name="userLessonLessonId" required>
                    </div>
                    <div class="mb-3">
                        <label for="userLessonCompletionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="userLessonCompletionDate" name="userLessonCompletionDate" required max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editUserLessonProgressModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Lesson Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserLessonProgressForm">
                    <div class="mb-3">
                        <label for="editUserLessonUserId" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="editUserLessonUserId" name="editUserLessonUserId" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editUserLessonLessonId" class="form-label">Lesson ID</label>
                        <input type="number" class="form-control" id="editUserLessonLessonId" name="editUserLessonLessonId" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editUserLessonCompletionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="editUserLessonCompletionDate" name="editUserLessonCompletionDate" required max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary float-end ps-5 pe-5 mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
