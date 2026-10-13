<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Professional in Digital Marketing (PIDM) Program | AGDM Academy";
$pageDescription = "Enroll in our 4-month fast-track Professional in Digital Marketing (PIDM) course in Uttam Nagar, Delhi. Practical, job-oriented modules & placement support.";
$pageKeywords = "professional in digital marketing, pidm course delhi, 4 months digital marketing, fast track digital marketing program, social media management training, seo basics course, digital marketing for freshers";

$pageSchema = <<<HTML
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "Professional in Digital Marketing (PIDM)",
  "description": "Enroll in our 4-month fast-track Professional in Digital Marketing (PIDM) course in Uttam Nagar, Delhi. Practical, job-oriented modules & placement support.",
  "provider": {
    "@type": "EducationalOrganization",
    "name": "AGDM Academy",
    "sameAs": "https://agdmacademy.com"
  }
}
</script>
HTML;

agdm_include_part('header.php');
?>

<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">⭐ Job-Oriented Program</span>
        <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2;">Professional in <span class="text-danger">Digital Marketing</span></h1>
        <p class="lead text-white-50 mb-4">A practical, fast-track 4-month program designed for learners who want to gain strong digital marketing skills and become job-ready quickly.</p>
        
        <div class="d-flex flex-wrap gap-3 mb-5">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">15+ Practical Modules</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">Live Project Exposure</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">Job-Ready Skills</span>
          </div>
        </div>
        
        <div class="d-flex gap-3 flex-wrap">
          <a href="#enroll" class="btn btn-danger btn-lg px-4 rounded-pill fw-bold shadow">🚀 Apply for PIDM</a>
          <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold"><i class="bi bi-download me-2"></i> Download Syllabus</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="row g-4">
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">3+1<span class="text-danger"> mo</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Duration</p>
            </div>
          </div>
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">100<span class="text-danger">%</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Practical</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Abstract shape in background -->
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 400px; height: 400px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
</section>

<!-- OVERVIEW -->
<section class="py-5 bg-white anim-fade" id="overview">
  <div class="container py-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Overview</span>
        <h2 class="display-6 fw-bold mb-4">Fast-Track Your Marketing Career</h2>
        <p class="lead text-muted mb-4">Professional in Digital Marketing is a practical and job-oriented program designed for learners who want to gain strong digital marketing skills in a shorter duration.</p>
        <p class="text-muted mb-4">This 3+1 month program focuses on essential marketing strategies, professional tools, and hands-on practical learning to help students become job-ready quickly.</p>
        <p class="text-muted mb-0">It is ideal for beginners, students, freshers, and business owners who want to understand how digital platforms work and how to use them effectively for career growth and business success.</p>
      </div>
      <div class="col-lg-6">
        <div class="position-relative">
          <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?q=80&w=800&auto=format&fit=crop" alt="Digital Marketing Training" class="img-fluid rounded-4 shadow-lg">
          <div class="position-absolute bottom-0 start-0 bg-white p-4 rounded-3 shadow-lg" style="transform: translate(-20px, 20px);">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-rocket-takeoff fs-4"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">3+1 Months</h4>
                <p class="text-muted mb-0 small">Fast-Track</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHAT YOU WILL LEARN -->
<section class="py-5 bg-light anim-fade" id="syllabus">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Syllabus</span>
      <h2 class="fw-bold">What You Will Learn</h2>
      <p class="section-subtitle">Essential modules designed for immediate industry application.</p>
    </div>
    <div class="row g-4">
      <?php
      $modules = [
        ["Fundamentals of Digital Marketing", "bi-book", "text-primary"],
        ["Search Engine Optimization (SEO)", "bi-search", "text-success"],
        ["Social Media Management", "bi-share", "text-info"],
        ["Google Ads", "bi-google", "text-danger"],
        ["Meta Ads", "bi-meta", "text-primary"],
        ["Content Creation & Branding", "bi-palette", "text-warning"],
        ["Website Designing", "bi-laptop", "text-secondary"],
        ["Lead Generation", "bi-magnet", "text-danger"],
        ["Performance Marketing", "bi-graph-up-arrow", "text-info"],
        ["Introduction to Marketing Tools", "bi-tools", "text-secondary"],
        ["Reporting & Analysis", "bi-bar-chart-fill", "text-success"],
        ["Practical Assignments", "bi-journal-check", "text-warning"],
        ["Live Project Exposure", "bi-briefcase", "text-primary"]
      ];
      foreach ($modules as $mod) {
        echo '
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card border-0 shadow-sm h-100 rounded-3 p-3 d-flex flex-row align-items-center gap-3 tool-box">
            <i class="bi '.$mod[1].' fs-4 '.$mod[2].'"></i>
            <span class="fw-semibold text-dark fs-6" style="line-height: 1.2;">'.$mod[0].'</span>
          </div>
        </div>';
      }
      ?>
    </div>
  </div>
</section>

<!-- WHO CAN JOIN & CAREER OPPS -->
<section class="py-5 bg-white anim-fade">
  <div class="container py-4">
    <div class="row g-5">
      <div class="col-lg-6">
        <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Target Audience</span>
        <h2 class="fw-bold mb-4">Who Can Join?</h2>
        <div class="row g-3">
          <?php
          $audience = ["Beginners", "Students", "Freshers", "Job Seekers", "Small Business Owners", "Freelancers"];
          foreach ($audience as $aud) {
            echo '
            <div class="col-md-6">
               <div class="d-flex align-items-center gap-2 p-3 bg-light rounded-3">
                 <i class="bi bi-check-circle-fill text-danger"></i>
                 <span class="fw-medium">'.$aud.'</span>
               </div>
            </div>';
          }
          ?>
        </div>
      </div>
      <div class="col-lg-6">
        <span class="text-primary fw-bold text-uppercase tracking-wider mb-2 d-block">Future Paths</span>
        <h2 class="fw-bold mb-4">Career Opportunities</h2>
        <div class="row g-3">
          <?php
          $careers = ["Digital Marketing Executive", "Social Media Executive", "SEO Assistant", "Content Executive", "Junior Ads Specialist", "Marketing Coordinator"];
          foreach ($careers as $car) {
            echo '
            <div class="col-md-6">
               <div class="d-flex align-items-center gap-2 p-3 border rounded-3 tool-box">
                 <i class="bi bi-briefcase-fill text-primary"></i>
                 <span class="fw-medium">'.$car.'</span>
               </div>
            </div>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING/ENROLL -->
<section class="py-5 bg-light anim-fade" id="enroll">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Pricing & Enrollment</span>
      <h2 class="fw-bold">Secure Your <span class="text-danger">Seat</span></h2>
      <p class="section-subtitle">Affordable pricing for a high-ROI career move.</p>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative h-100">
          <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius: 1rem;">🔥 FAST TRACK</div>
          <div class="card-body p-5 d-flex flex-column text-center">
            <h4 class="fw-bold mb-3 mt-2">Professional in Digital Marketing</h4>
            <div class="mb-4">
            <ul class="list-unstyled mb-5 flex-grow-1 text-start d-inline-block mx-auto">
              <li class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                <span class="text-muted fw-medium">3+1 Month Intensive Program</span>
              </li>
              <li class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                <span class="text-muted fw-medium">Weekday &amp; Weekend Batches</span>
              </li>
              <li class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                <span class="text-muted fw-medium">Social Media & Brand Strategy</span>
              </li>
              <li class="d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                <span class="text-muted fw-medium">Certification Provided</span>
              </li>
            </ul>
            
            <div class="mb-4">
               <span class="badge bg-light text-dark border p-2 px-3 fs-6">Fee: Get Pricing</span>
            </div>
            <a href="contact.php" class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow">Apply for PIDM →</a>
            <div class="mt-3">
              <a href="faq.php" class="text-muted small text-decoration-none">Have questions? View our FAQs <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.anim-fade').forEach(el => observer.observe(el));
  });
</script>

<?php agdm_include_part('footer.php'); ?>
