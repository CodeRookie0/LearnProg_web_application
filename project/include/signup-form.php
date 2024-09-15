<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<section class="bg-light" id="signup-section">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 175px);">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5 ">
                        <div class="text-center mb-5">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h2 class="fw-bolder">Sign Up</h2>
                            <p class="lead mb-0">Create your account</p>
                        </div>
                        <?php if(!empty($error_message)) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top: -35px;">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>
                        <form action="../actions/signup-handler.php" method="post">
                            <!-- Username input-->
                            <div class="form-floating mb-3">
                                <input
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    type="text"
                                    placeholder="Enter your username..."
                                    maxlength = "35"
                                    required
                                />
                                <label for="username">Username</label>
                            </div>
                            <!-- Email input-->
                            <div class="form-floating mb-3">
                                <input
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="name@example.com"
                                    maxlength = "35"
                                    required
                                />
                                <label for="email">Email address</label>
                            </div>
                            <div class="row mb-3">
                                <!-- Password input-->
                                <div class="col">
                                    <div class="form-floating">
                                        <input
                                            class="form-control"
                                            id="password"
                                            name="password"
                                            type="password"
                                            placeholder="Enter your password..."
                                            maxlength = "35"
                                            required
                                        />
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <!-- Confirm Password input-->
                                <div class="col">
                                    <div class="form-floating">
                                        <input
                                            class="form-control"
                                            id="confirm_password"
                                            name="confirm_password"
                                            type="password"
                                            placeholder="Confirm your password..."
                                            maxlength = "35"
                                            required
                                        />
                                        <label for="confirmPassword">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Button-->
                            <div class="d-grid mb-3">
                                <button
                                    class="btn btn-primary btn-lg"
                                    id="signupButton"
                                    name="signup"
                                    type="submit"
                                >
                                    Sign up
                                </button>
                            </div>
                            <div class="text-center">
                                <p class="mt-3 mb-0">Already have an account? <a href="login.php" class="btn btn-link mb-1">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

