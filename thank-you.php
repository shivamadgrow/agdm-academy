<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle       = "Thank You — Registration Received | AGDM Academy";
$pageDescription = "Thank you for reaching out to AGDM Academy. Your inquiry has been received and our team will contact you shortly.";
$noIndex         = true; // Prevent search engines from indexing this page

agdm_include_part('header.php');
?>

<!-- ====================================================
     GOOGLE ADS CONVERSION TRACKING
     Replace CONVERSION_ID and CONVERSION_LABEL below
     with values from your Google Ads account:
     Tools & Settings → Conversions → [Your Conversion] → Tag setup
===================================================== -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-CONVERSION_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){ dataLayer.push(arguments); }
  gtag('js', new Date());

  // Page-level config — replace AW-CONVERSION_ID with your actual ID
  gtag('config', 'AW-CONVERSION_ID');

  // Fire the conversion event when this page loads
  gtag('event', 'conversion', {
    'send_to': 'AW-CONVERSION_ID/CONVERSION_LABEL',
    'value':    1.0,
    'currency': 'INR'
  });
</script>
<!-- ====================================================
     END GOOGLE ADS CONVERSION TRACKING
===================================================== -->

<!-- CONFETTI CANVAS (decorative) -->
<canvas id="confettiCanvas" style="position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;"></canvas>

<!-- HERO / THANK YOU SECTION -->
<section class="ty-hero py-5 bg-dark text-white position-relative overflow-hidden">
  <!-- Decorative blobs -->
  <div class="position-absolute top-0 end-0 opacity-25" style="width:380px;height:380px;background:radial-gradient(circle,#dc3545 0%,transparent 70%);border-radius:50%;transform:translate(35%,-35%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-20" style="width:280px;height:280px;background:radial-gradient(circle,#0d6efd 0%,transparent 70%);border-radius:50%;transform:translate(-35%,35%);"></div>

  <div class="container py-5 position-relative z-1 text-center">
    <!-- Success Icon -->
    <div class="ty-icon-ring mx-auto mb-4" id="successRing">
      <div class="ty-icon-inner">
        <i class="bi bi-check-lg"></i>
      </div>
    </div>

    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase" style="letter-spacing:.08em;">Enrollment Received</span>

    <h1 class="display-4 fw-bold mb-3">
      You're One Step Closer to Your <span class="text-danger">Dream Career!</span>
    </h1>
    <p class="lead text-white-50 mx-auto mb-5" style="max-width:640px;">
      Thank you for reaching out to <strong class="text-white">AGDM Academy</strong>. Our admissions counselor will call you within <strong class="text-warning">24 hours</strong> to guide you through the next steps.
    </p>

    <?php if (isset($_GET['download']) && $_GET['download'] === 'syllabus'): ?>
      <div class="alert alert-success mx-auto mb-5 text-dark text-start shadow-sm" style="max-width:600px; border-radius: 12px; background-color: #d1e7dd; border-color: #badbcc; border-left: 5px solid #198754;">
        <h5 class="fw-bold mb-1 text-success"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Syllabus Download Started!</h5>
        <p class="mb-2 small text-muted">We have started downloading the <strong>AGDM Course Syllabus</strong>. If the download didn't start automatically, please click the button below to get it directly.</p>
        <a href="assets/agdm_brochure.pdf" download="agdm_course_syllabus.pdf" class="btn btn-success btn-sm fw-bold"><i class="bi bi-download me-1"></i>Download Manually</a>
      </div>
      <script>
        window.addEventListener('load', function() {
          setTimeout(function() {
            const a = document.createElement('a');
            a.href = 'assets/agdm_brochure.pdf';
            a.download = 'agdm_course_syllabus.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
          }, 800);
        });
      </script>
    <?php endif; ?>

    <!-- CTA Buttons -->
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="https://agdmacademy.com/" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow">
        <i class="bi bi-house-fill me-2"></i>Back to Home
      </a>
      <a href="courses.php" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">
        <i class="bi bi-mortarboard-fill me-2"></i>Explore Courses
      </a>
    </div>
  </div>
</section>

<!-- WHAT HAPPENS NEXT -->
<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase mb-2 d-block" style="letter-spacing:.08em;">Your Journey Begins</span>
      <h2 class="display-6 fw-bold">What Happens Next?</h2>
      <p class="text-muted mx-auto" style="max-width:540px;">Here's a quick look at what to expect after submitting your inquiry.</p>
    </div>

    <div class="row g-4 justify-content-center">
      <!-- Step 1 -->
      <div class="col-md-4">
        <div class="ty-step-card card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
          <div class="ty-step-num">01</div>
          <div class="ty-step-icon bg-danger bg-opacity-10 text-danger mx-auto mb-3">
            <i class="bi bi-telephone-fill fs-3"></i>
          </div>
          <h5 class="fw-bold mb-2">Counselor Call</h5>
          <p class="text-muted mb-0 small">Our admissions expert will call you within 24 hours to understand your goals and answer your questions.</p>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="col-md-4">
        <div class="ty-step-card card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
          <div class="ty-step-num">02</div>
          <div class="ty-step-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
            <i class="bi bi-calendar2-check-fill fs-3"></i>
          </div>
          <h5 class="fw-bold mb-2">Demo Session</h5>
          <p class="text-muted mb-0 small">We'll invite you for a free live demo class so you can experience our teaching style first-hand.</p>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="col-md-4">
        <div class="ty-step-card card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
          <div class="ty-step-num">03</div>
          <div class="ty-step-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
            <i class="bi bi-rocket-takeoff-fill fs-3"></i>
          </div>
          <h5 class="fw-bold mb-2">Start Learning</h5>
          <p class="text-muted mb-0 small">Complete your enrollment, get access to our LMS, and start building real-world digital marketing skills.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOCIAL PROOF STRIP -->
<section class="py-5 bg-dark text-white">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3">
        <div class="ty-stat">
          <span class="ty-stat-num text-danger">200<span class="text-white">+</span></span>
          <span class="ty-stat-label">Students Trained</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="ty-stat">
          <span class="ty-stat-num text-danger">98<span class="text-white">%</span></span>
          <span class="ty-stat-label">Placement Support Rate</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="ty-stat">
          <span class="ty-stat-num text-danger">50<span class="text-white">+</span></span>
          <span class="ty-stat-label">Modules Covered</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="ty-stat">
          <span class="ty-stat-num text-danger">4.9<span class="text-white">★</span></span>
          <span class="ty-stat-label">Google Rating</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- QUICK CONTACT INFO -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4">
      <h3 class="fw-bold">Need Immediate Help?</h3>
      <p class="text-muted">Reach us directly — we're always happy to assist.</p>
    </div>
    <div class="row g-3 justify-content-center">
      <div class="col-auto">
        <a href="tel:+919643661661" class="btn btn-outline-danger btn-lg rounded-pill px-4">
          <i class="bi bi-telephone-fill me-2"></i>+91 9643661661
        </a>
      </div>
      <div class="col-auto">
        <a href="https://wa.me/919643661661?text=Hi%2C%20I%20just%20submitted%20an%20inquiry%20on%20AGDM%20Academy%20and%20need%20more%20information."
           target="_blank" rel="noopener"
           class="btn btn-success btn-lg rounded-pill px-4">
          <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
        </a>
      </div>
      <div class="col-auto">
        <a href="mailto:info@agdmacademy.com" class="btn btn-outline-dark btn-lg rounded-pill px-4">
          <i class="bi bi-envelope-fill me-2"></i>info@agdmacademy.com
        </a>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     PAGE-SPECIFIC STYLES
============================================= -->
<style>
/* ---- Success ring animation ---- */
.ty-icon-ring {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  background: rgba(220,53,69,.15);
  display: flex;
  align-items: center;
  justify-content: center;
  animation: ringPulse 2s ease-in-out infinite;
}
.ty-icon-inner {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: #dc3545;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.2rem;
  color: #fff;
  animation: iconPop .6s cubic-bezier(.17,.67,.5,1.4) both;
}
@keyframes ringPulse {
  0%,100% { box-shadow: 0 0 0 0 rgba(220,53,69,.3); }
  50%      { box-shadow: 0 0 0 18px rgba(220,53,69,0); }
}
@keyframes iconPop {
  0%   { transform: scale(0); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

/* ---- Step cards ---- */
.ty-step-card {
  transition: transform .3s ease, box-shadow .3s ease;
  position: relative;
  overflow: hidden;
}
.ty-step-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 40px rgba(0,0,0,.12) !important;
}
.ty-step-num {
  position: absolute;
  top: 12px;
  right: 18px;
  font-size: 3.5rem;
  font-weight: 800;
  color: rgba(0,0,0,.04);
  line-height: 1;
  font-family: 'Outfit', sans-serif;
}
.ty-step-icon {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ---- Stats strip ---- */
.ty-stat {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.ty-stat-num {
  font-size: 2.6rem;
  font-weight: 800;
  font-family: 'Outfit', sans-serif;
  line-height: 1;
}
.ty-stat-label {
  font-size: .85rem;
  color: rgba(255,255,255,.55);
  text-transform: uppercase;
  letter-spacing: .06em;
}

/* ---- Hero extra polish ---- */
.ty-hero {
  background: linear-gradient(135deg, #0d0d0d 0%, #1a0005 50%, #0d0d0d 100%);
  min-height: 70vh;
  display: flex;
  align-items: center;
}
</style>

<!-- =============================================
     CONFETTI SCRIPT
============================================= -->
<script>
(function(){
  const canvas = document.getElementById('confettiCanvas');
  const ctx    = canvas.getContext('2d');
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight;

  const colors  = ['#dc3545','#ffc107','#0d6efd','#198754','#fff','#fd7e14'];
  const pieces  = [];
  const total   = 150;

  for (let i = 0; i < total; i++) {
    pieces.push({
      x:   Math.random() * canvas.width,
      y:   Math.random() * -canvas.height,
      r:   Math.random() * 8 + 4,
      d:   Math.random() * total,
      col: colors[Math.floor(Math.random() * colors.length)],
      vx:  (Math.random() - 0.5) * 2,
      vy:  Math.random() * 3 + 2,
      tilt: Math.random() * 10 - 10,
      tiltAngle: 0,
      tiltSpeed: Math.random() * 0.1 + 0.05
    });
  }

  let frame = 0;
  let animId;

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieces.forEach(p => {
      ctx.save();
      ctx.beginPath();
      ctx.translate(p.x + p.tilt, p.y);
      ctx.rotate(p.tiltAngle);
      ctx.rect(-p.r/2, -p.r/2, p.r, p.r * 1.6);
      ctx.fillStyle = p.col;
      ctx.globalAlpha = 0.85;
      ctx.fill();
      ctx.restore();
    });
    update();
    frame++;
    if (frame < 300) {
      animId = requestAnimationFrame(draw);
    } else {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
  }

  function update() {
    pieces.forEach(p => {
      p.tiltAngle += p.tiltSpeed;
      p.y         += p.vy;
      p.x         += p.vx;
      p.tilt       = Math.sin(p.tiltAngle) * 12;
      if (p.y > canvas.height + 20) {
        p.y = -20;
        p.x = Math.random() * canvas.width;
      }
    });
  }

  window.addEventListener('resize', () => {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  });

  draw();
  // Mark leadPopupShown as true so converted users never see the popup
  localStorage.setItem('leadPopupShown', 'true');
})();
</script>

<?php agdm_include_part('footer.php'); ?>
