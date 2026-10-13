<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Master in Digital Marketing (MIDM) Course | AGDM Academy Delhi";
$pageDescription = "Join the 8-month Master in Digital Marketing (MIDM) program in Uttam Nagar, Delhi. Learn 50+ modules with 100% practical training, live ads spend, and 100% placement support.";
$pageKeywords = "master in digital marketing, midm course delhi, 8 months digital marketing program, advanced digital marketing certification, website planning training, PPC training, performance marketing course, lead generation course";

$pageSchema = <<<HTML
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "Master in Digital Marketing (MIDM)",
  "description": "Join the 8-month Master in Digital Marketing (MIDM) program in Uttam Nagar, Delhi. Learn 50+ modules with 100% practical training, live ads spend, and 100% placement support.",
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
        <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">⭐ Our Flagship Program</span>
        <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2;">Master Digital Marketing & <span class="text-danger">Become Unstoppable</span></h1>
        <p class="lead text-white-50 mb-4">A comprehensive 8-month program for students, job seekers, and professionals looking to build a strong future in digital marketing.</p>
        
        <div class="d-flex flex-wrap gap-3 mb-5">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">50+ Core Modules</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">1-on-1 Mentorship</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger"></i>
            <span class="fw-medium">Agency Level Training</span>
          </div>
        </div>
        
        <div class="d-flex gap-3 flex-wrap">
          <a href="#enroll" class="btn btn-danger btn-lg px-4 rounded-pill fw-bold shadow">🚀 Apply for MIDM</a>
          <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold"><i class="bi bi-download me-2"></i> Download Brochure</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="row g-4">
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">100<span class="text-danger">+</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Alumni</p>
            </div>
          </div>
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">6+2<span class="text-danger">mo</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Duration</p>
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
          <h2 class="display-6 fw-bold mb-4">A Comprehensive, Career-Focused Curriculum</h2>
          <p class="lead text-muted mb-4">Master in Digital Marketing (MIDM) is our most comprehensive program designed for students, job seekers, freelancers, business owners, and working professionals who want to build a strong future in digital marketing.</p>
          <p class="text-muted mb-4">This 8-month program covers everything from basic concepts to advanced-level strategies with practical implementation and live project training. The course is specially designed to make you industry-ready by giving you hands-on experience in SEO, Google Ads, Social Media Marketing, Website Development, Performance Marketing, Lead Generation, and much more.</p>
          <p class="text-muted mb-0">Whether you want a high-paying job, freelance clients, or your own business growth, this course helps you achieve your goals.</p>
        </div>
        <div class="col-lg-6">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800&auto=format&fit=crop" alt="Digital Marketing Training" class="img-fluid rounded-4 shadow-lg">
            <div class="position-absolute bottom-0 start-0 bg-white p-4 rounded-3 shadow-lg" style="transform: translate(-20px, 20px);">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                  <h4 class="fw-bold mb-0">6+2 Months</h4>
                  <p class="text-muted mb-0 small">Duration</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- WHAT YOU WILL LEARN -->
  <style>
    .brand-google {
      color: #4285F4 !important;
    }
    .brand-meta {
      color: #0668E1 !important;
    }
  </style>
  <section class="py-5 bg-light anim-fade" id="syllabus">
    <div class="container py-4">
      <div class="text-center mb-5">
        <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Syllabus</span>
        <h2 class="fw-bold">What You Will Learn</h2>
        <p class="section-subtitle">50 in-depth modules to make you a complete digital marketer.</p>
      </div>
      <div class="row g-4">
        <?php
        $modules = [
          ["Website Planning & Development", "bi-laptop", "text-primary"],
          ["Search Engine Optimization (SEO)", "bi-search", "text-success"],
          ["Google Ads (PPC)", "bi-google", "brand-google"],
          ["Facebook & Instagram Ads", "bi-meta", "brand-meta"],
          ["Social Media Marketing (SMM)", "bi-share", "text-info"],
          ["YouTube Marketing", "bi-youtube", "text-danger"],
          ["Content Marketing", "bi-pencil-square", "text-warning"],
          ["Email Marketing", "bi-envelope-paper", "text-success"],
          ["Affiliate Marketing", "bi-link-45deg", "text-secondary"],
          ["E-commerce Marketing", "bi-cart3", "text-primary"],
          ["Lead Generation Strategies", "bi-magnet", "text-danger"],
          ["Performance Marketing", "bi-graph-up-arrow", "text-info"],
          ["Google Analytics", "bi-bar-chart-fill", "text-warning"],
          ["Freelancing & Client Handling", "bi-person-workspace", "text-success"],
          ["Interview Preparation", "bi-person-check", "text-primary"],
          ["Live Projects & Case Studies", "bi-briefcase", "text-secondary"],
          ["Certification Guidance", "bi-award", "text-danger"]
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
            $audience = ["Students", "Freshers", "Job Seekers", "Working Professionals", "Business Owners", "Entrepreneurs", "Freelancers"];
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
            $careers = ["Digital Marketing Executive", "SEO Executive", "Social Media Manager", "Google Ads Specialist", "Performance Marketer", "Content Strategist", "Freelancer", "Agency Owner"];
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
        <h2 class="fw-bold">Invest in Your <span class="text-danger">Future</span></h2>
        <p class="section-subtitle">Flexible payment plans to accelerate your career growth.</p>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative h-100">
            <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius: 1rem;">🔥 MASTER CLASS</div>
            <div class="card-body p-5 d-flex flex-column text-center">
              <h4 class="fw-bold mb-3 mt-2">Master in Digital Marketing</h4>
              <div class="mb-4">
              </div>
              
              <ul class="list-unstyled mb-5 flex-grow-1 text-start d-inline-block mx-auto">
                <li class="d-flex align-items-center gap-3 mb-3">
                  <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                  <span class="text-muted fw-medium">Complete 50 Core Modules</span>
                </li>
                <li class="d-flex align-items-center gap-3 mb-3">
                  <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                  <span class="text-muted fw-medium">Live Ad Account Spending</span>
                </li>
                <li class="d-flex align-items-center gap-3 mb-3">
                  <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                  <span class="text-muted fw-medium">1-on-1 Mentor Support</span>
                </li>
                <li class="d-flex align-items-center gap-3 mb-3">
                  <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                  <span class="text-muted fw-medium">Agency Apprenticeship</span>
                </li>
                <li class="d-flex align-items-center gap-3">
                  <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                  <span class="text-muted fw-medium">Premium Certifications</span>
                </li>
              </ul>
              <div class="mb-4">
              <a href="contact.php" class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow">Apply for MIDM →</a>
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
