<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Contact AGDM Academy | Top Digital Marketing Institute in Delhi";
$pageDescription = "Get in touch with AGDM Academy. We are here to answer all your questions about our digital marketing programs and admissions.";
$pageKeywords = "contact agdm academy, digital marketing institute contact number, learn digital marketing delhi address, call digital marketing counselor, book demo class, uttam nagar institute contact";

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $phone   = trim($_POST['phone']   ?? '');
  $message = trim($_POST['message'] ?? '');
  $city    = trim($_POST['city']    ?? '');
  $course  = trim($_POST['course']  ?? '');
  $profile = trim($_POST['profile'] ?? '');

  if ($name === '') {
    $errors[] = "Name is required.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email is required.";
  }
  if ($phone === '') {
    $errors[] = "Phone number is required.";
  }
  if ($course === '') {
    $errors[] = "Please select a course you are interested in.";
  }
  if ($message === '') {
    $errors[] = "Please enter your query.";
  }

  $captcha = trim($_POST['agdm_captcha'] ?? '');
  if ($captcha === '') {
    $errors[] = "Verification is required. Please solve the math problem.";
  } elseif (!agdm_validate_captcha($captcha)) {
    $errors[] = "Incorrect verification answer. Please try again.";
  }

  if (!$errors) {
    $to = "info@agdmacademy.com";
    $subject = "New Inquiry from AGDM Academy Contact Form";
    $body = "New Inquiry from AGDM Academy Contact Form\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "City: $city\n";
    $body .= "Course Interested In: $course\n";
    $body .= "Current Profile: $profile\n";
    $body .= "\nMessage:\n$message";
    $headers = "From: no-reply@agdmacademy.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    @mail($to, $subject, $body, $headers);
    // Redirect to Thank You page for Google Ads conversion tracking
    header('Location: thank-you.php');
    exit;
  }
}

agdm_include_part('header.php');
?>

<!-- HERO SECTION -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1 text-center">
    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">Contact Us</span>
    <h1 class="display-4 fw-bold mb-3">Let's Start a <span class="text-danger">Conversation</span></h1>
    <p class="lead text-white-50 mx-auto" style="max-width: 600px;">Have questions about our programs, admissions, or digital marketing in general? We're here to help.</p>
  </div>
  
  <!-- Abstract shape in background -->
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-25" style="width: 200px; height: 200px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
</section>

<!-- CONTACT SECTION -->
<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="row g-5">
      
      <!-- Contact Info -->
      <div class="col-lg-5">
        <div class="pe-lg-4">
          <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Get in Touch</span>
          <h2 class="display-6 fw-bold mb-4">We are always ready to help you</h2>
          <p class="text-muted mb-5">Whether you're a student looking to start your career or a business owner wanting to grow online, reach out to our admissions counselors today.</p>
          
          <div class="d-flex flex-column gap-4">
            <div class="d-flex align-items-center gap-4 bg-white p-4 rounded-4 shadow-sm border border-light">
              <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                <i class="bi bi-envelope-fill fs-3"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-1">Email Us</h5>
                <a href="mailto:info@agdmacademy.com" class="text-muted text-decoration-none">info@agdmacademy.com</a>
              </div>
            </div>
            
            <div class="d-flex align-items-center gap-4 bg-white p-4 rounded-4 shadow-sm border border-light">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                <i class="bi bi-telephone-fill fs-3"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-1">Call Us</h5>
                <a href="tel:+919643661661" class="text-muted d-block text-decoration-none">+91 9643661661</a>
                <a href="tel:+918796911169" class="text-muted d-block text-decoration-none">+91 8796911169</a>
              </div>
            </div>
            
            <div class="d-flex align-items-center gap-4 bg-white p-4 rounded-4 shadow-sm border border-light">
              <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                <i class="bi bi-geo-alt-fill fs-3"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-1">Visit Us</h5>
                <p class="text-muted mb-0">Third Floor, E90A, Pankha Rd, opposite Palazzo Inn, Block F, Jivan Park, Uttam Nagar, New Delhi, Delhi, 110059</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 p-md-5 p-4 h-100">
          <h3 class="fw-bold mb-4">Send Us a Message</h3>
          
          <?php if ($success): ?>
            <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 border-0 bg-success bg-opacity-10 text-success p-4 mb-4">
              <i class="bi bi-check-circle-fill fs-3"></i>
              <div>
                <h5 class="fw-bold mb-1">Message Sent Successfully!</h5>
                <p class="mb-0 small">Thank you for reaching out. Our counseling team will contact you shortly.</p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($errors): ?>
            <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger p-4 mb-4">
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <h6 class="fw-bold mb-0">Please fix the following errors:</h6>
              </div>
              <ul class="mb-0 ps-4">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" action="contact.php#form-section" id="form-section">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-lg bg-light border-0" name="name" placeholder="Your Full Name" value="<?= htmlspecialchars($_POST['name'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-lg bg-light border-0" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-lg bg-light border-0" name="phone" placeholder="+91 XXXXXXXXXX" value="<?= htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">City / Location</label>
                <input type="text" class="form-control form-control-lg bg-light border-0" name="city" placeholder="e.g. New Delhi" value="<?= htmlspecialchars($_POST['city'] ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Course Interested In <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg bg-light border-0" name="course" required>
                  <option value="" disabled <?= empty($_POST['course']) ? 'selected' : ''; ?>>Select a Program</option>
                  <option value="MIDM" <?= (($_POST['course'] ?? '') === 'MIDM') ? 'selected' : ''; ?>>Master in Digital Marketing (MIDM)</option>
                  <option value="PIDM" <?= (($_POST['course'] ?? '') === 'PIDM') ? 'selected' : ''; ?>>Professional in Digital Marketing (PIDM)</option>
                  <option value="Other" <?= (($_POST['course'] ?? '') === 'Other') ? 'selected' : ''; ?>>Not Sure / Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Current Profile</label>
                <select class="form-select form-select-lg bg-light border-0" name="profile">
                  <option value="" disabled <?= empty($_POST['profile']) ? 'selected' : ''; ?>>Who are you?</option>
                  <option value="Student" <?= (($_POST['profile'] ?? '') === 'Student') ? 'selected' : ''; ?>>Student</option>
                  <option value="Fresher" <?= (($_POST['profile'] ?? '') === 'Fresher') ? 'selected' : ''; ?>>Fresher / Job Seeker</option>
                  <option value="Working Professional" <?= (($_POST['profile'] ?? '') === 'Working Professional') ? 'selected' : ''; ?>>Working Professional</option>
                  <option value="Business Owner" <?= (($_POST['profile'] ?? '') === 'Business Owner') ? 'selected' : ''; ?>>Business Owner / Entrepreneur</option>
                  <option value="Freelancer" <?= (($_POST['profile'] ?? '') === 'Freelancer') ? 'selected' : ''; ?>>Freelancer</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium text-dark">Your Query / Message <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-lg bg-light border-0" name="message" rows="4" placeholder="Tell us what you're looking for..." required><?= htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
              </div>
              <div class="col-12">
                <?= agdm_render_captcha(false); ?>
              </div>
              <div class="col-12 mt-2">
                <button class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow" type="submit">
                  <i class="bi bi-send-fill me-2"></i> Send Inquiry
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
</section>

<?php agdm_include_part('footer.php'); ?>
