<header class="bg-dark py-5">
	<div class="container px-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-6">
				<div class="text-center my-5">
					<?php
                        $title = isset($pageTitle) ? $pageTitle : "Embark on Your C++ Journey with LearnProg";
                        $description = isset($pageDescription) ? $pageDescription : "Welcome to LearnProg, your premier online resource for mastering C++. Whether you're a novice or an expert coder, we're here to guide you every step of the way. Start coding today!";
                    
                        $isIndexPage = basename($_SERVER['PHP_SELF']) === 'index.php';
					?>
                    <h1 class="display-5 fw-bolder text-white mb-2"><?php echo $title; ?></h1>
                    <p class="lead text-white-50 mb-4"><?php echo $description; ?></p>
					
					<?php if($isIndexPage): ?>
					<div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
						<a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Get Started</a>
						<a class="btn btn-outline-light btn-lg px-4" href="#contact-section">Contact Us</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</header>