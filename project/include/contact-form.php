<section class="bg-light py-5" id="contact-section">
	<div class="container px-5 my-5 px-5">
		<div class="text-center mb-5">
			<div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
				<i class="bi bi-envelope"></i>
			</div>
			<h2 class="fw-bolder">Get in touch</h2>
			<p class="lead mb-0">We'd love to hear from you</p>
		</div>
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-6">
				<form id="contactForm" data-sb-form-api-token="API_TOKEN">
					<!-- Name input-->
					<div class="form-floating mb-3">
						<input
							class="form-control"
							id="name"
							type="text"
							placeholder="Enter your name..."
                            maxlength = "35"
							data-sb-validations="required"
						/>
						<label for="name">Full name</label>
						<div class="invalid-feedback" data-sb-feedback="name:required">
							A name is required.
						</div>
					</div>
					<!-- Email address input-->
					<div class="form-floating mb-3">
						<input
							class="form-control"
							id="email"
							type="email"
							placeholder="name@example.com"
                            maxlength = "35"
							data-sb-validations="required,email"
						/>
						<label for="email">Email address</label>
						<div class="invalid-feedback" data-sb-feedback="email:required">
							An email is required.
						</div>
						<div class="invalid-feedback" data-sb-feedback="email:email">
							Email is not valid.
						</div>
					</div>
					<!-- Phone number input-->
					<div class="form-floating mb-3">
						<input
							class="form-control"
							id="phone"
							type="tel"
							placeholder="(123) 456-7890"
                            maxlength = "35"
							data-sb-validations="required"
						/>
						<label for="phone">Phone number</label>
						<div class="invalid-feedback" data-sb-feedback="phone:required">
							A phone number is required.
						</div>
					</div>
					<!-- Message input-->
					<div class="form-floating mb-3">
						<textarea
							class="form-control"
							id="message"
							type="text"
							placeholder="Enter your message here..."
                            maxlength = "255"
							style="height: 10rem"
							data-sb-validations="required"
						></textarea>
						<label for="message">Message</label>
						<div class="invalid-feedback" data-sb-feedback="message:required">
							A message is required.
						</div>
					</div>
					<!-- Submit success message-->
					<div class="d-none" id="submitSuccessMessage">
						<div class="text-center mb-3">
							<div class="fw-bolder">Thank you!</div>
							<p>Your message has been submitted.</p>
						</div>
					</div>
					<!-- Submit error message-->
					<div class="d-none" id="submitErrorMessage">
						<div class="text-center text-danger mb-3">
							Error sending message!
						</div>
					</div>
					<!-- Submit Button-->
					<div class="d-grid">
						<button
							class="btn btn-primary btn-lg disabled"
							id="submitButton"
							type="submit"
						>
							Submit
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>