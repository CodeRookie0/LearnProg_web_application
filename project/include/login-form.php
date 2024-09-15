<section class="bg-light" id="login-section">
    <div class="container ">
        <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 175px);">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5 ">
                        <div class="text-center mb-5">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-person"></i>
                            </div>
                            <h2 class="fw-bolder">Login</h2>
                            <p class="lead mb-0">Please sign in to access your account</p>
                        </div>
                        <?php if(!empty($error_message)) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top: -35px;">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($success_message)) : ?>
                            <div class="alert alert-success" role="alert" style="margin-top: -35px;">
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>
                        <form action="../actions/login_handler.php" method="post">
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
                            <!-- Password input-->
                            <div class="form-floating mb-3">
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
                            <!-- Submit Button-->
                            <div class="d-grid mb-3">
                                <button
                                    class="btn btn-primary btn-lg"
                                    id="loginButton"
                                    type="submit"
                                >
                                    Login
                                </button>
                            </div>
                            <div class="text-center">
                                <p class="mt-3 mb-2">Don't have an account? <a href="signup.php" class="btn btn-link mb-1">Sign up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
