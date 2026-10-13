<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Digital Marketing Course FAQs & Admissions | AGDM Academy";
$pageDescription = "Have questions about our digital marketing courses? Find answers about placements, live projects, syllabus, and more at AGDM Academy Delhi.";
$pageKeywords = "digital marketing faq, digital marketing course queries, placement assistance details, live projects faq, digital marketing class duration, digital marketing certifications eligibility";
agdm_include_part('header.php');
?>

<section class="py-5 bg-light text-center">
  <div class="container py-4">
    <h1 class="display-5 fw-bold mb-3">Frequently Asked Questions</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">Everything you need to know about our digital marketing programs and career support.</p>
  </div>
</section>

<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="faqAccordion">
          <!-- Question 1 -->
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Is this digital marketing course suitable for beginners?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted">
                Yes, our programs are designed from scratch. Whether you are a student, professional, or business owner with no prior technical knowledge, you can easily grasp the concepts.
              </div>
            </div>
          </div>
          <!-- Question 2 -->
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Do you provide placement assistance?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted">
                Absolutely! We offer 100% placement assistance including resume building, mock interviews, and connections to our 750+ hiring partners.
              </div>
            </div>
          </div>
          <!-- Question 3 -->
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Will I get to work on live projects?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted">
                Yes, training is 100% practical. You will work on live campaigns, allocate real ad budgets, and track real-time analytics to build a strong portfolio.
              </div>
            </div>
          </div>
          <!-- Question 4 -->
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                What are the class timings?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted">
                We offer flexible batches including weekday morning (10AM-12PM) and weekend batches (Sat-Sun 11AM-3PM) to suit your schedule.
              </div>
            </div>
          </div>
          <!-- Question 5 -->
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Do you provide certificates?
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted">
                Yes, you will receive an industry-recognized certificate from AGDM Academy and guidance to obtain global certifications from Google, Meta, and HubSpot.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-5 bg-dark text-white text-center">
  <div class="container py-4">
    <h2 class="fw-bold mb-4">Still have more questions?</h2>
    <p class="lead mb-5 text-white-50">Talk to our career counselor for a free session and get all your doubts cleared.</p>
    <a href="contact.php" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow">Talk to Counselor</a>
  </div>
</section>

<!-- FAQ Page Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is this digital marketing course suitable for beginners?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our programs are designed from scratch. Whether you are a student, professional, or business owner with no prior technical knowledge, you can easily grasp the concepts."
      }
    },
    {
      "@type": "Question",
      "name": "Do you provide placement assistance?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! We offer 100% placement assistance including resume building, mock interviews, and connections to our 750+ hiring partners."
      }
    },
    {
      "@type": "Question",
      "name": "Will I get to work on live projects?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, training is 100% practical. You will work on live campaigns, allocate real ad budgets, and track real-time analytics to build a strong portfolio."
      }
    }
  ]
}
</script>

<?php agdm_include_part('footer.php'); ?>
