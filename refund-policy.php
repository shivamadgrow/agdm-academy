<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Refund & Cancellation Policy | AGDM Academy Delhi";
$pageDescription = "Refund and Cancellation Policy for AGDM Academy. Read our guidelines on course fee refunds and cancellations.";
$pageKeywords = "refund policy, cancellation policy, course fee refund, fee cancellation agdm";
agdm_include_part('header.php');
?>

<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-3">Refund &amp; Cancellation Policy</h1>
        <p class="lead text-white-50 mb-0">Please read our refund and cancellation guidelines carefully before enrolling.</p>
      </div>
    </div>
  </div>
  <!-- Abstract shape in background -->
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
</section>

<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="content-wrapper text-muted lh-lg">

          <ul class="list-unstyled d-flex flex-column gap-4 mb-0">
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-x-circle-fill fs-6"></i>
              </div>
              <p class="mb-0">Course fees paid to AGDM Academy are <strong class="text-dark">generally non-refundable</strong> once enrollment is confirmed.</p>
            </li>
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-cash-coin fs-6"></i>
              </div>
              <p class="mb-0">Any approved refund will be processed after deducting applicable <strong class="text-dark">administrative or processing charges</strong>.</p>
            </li>
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-slash-circle fs-6"></i>
              </div>
              <p class="mb-0"><strong class="text-dark">No refunds</strong> will be issued for partial attendance, missed sessions, or change of mind after course commencement.</p>
            </li>
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-check-circle-fill fs-6"></i>
              </div>
              <p class="mb-0">In case a course is <strong class="text-dark">cancelled by AGDM Academy</strong>, students will be eligible for a full or partial refund or an option to transfer to another batch.</p>
            </li>
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-clock-history fs-6"></i>
              </div>
              <p class="mb-0">Refunds, if applicable, will be processed within a <strong class="text-dark">reasonable time frame</strong> via the original payment method.</p>
            </li>
            <li class="d-flex gap-3 align-items-start">
              <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 34px; height: 34px;">
                <i class="bi bi-envelope-fill fs-6"></i>
              </div>
              <p class="mb-0">For any cancellation or refund requests, users must contact us at <a href="mailto:info@agdmacademy.com" class="text-danger fw-semibold text-decoration-none">info@agdmacademy.com</a> with relevant details.</p>
            </li>
          </ul>

          <div class="bg-light p-4 rounded-3 border mt-5">
            <p class="mb-0 text-muted"><i class="bi bi-info-circle text-danger me-2"></i> For any questions related to this policy, please reach out to us at <a href="mailto:info@agdmacademy.com" class="text-decoration-none fw-semibold text-dark">info@agdmacademy.com</a></p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php agdm_include_part('footer.php'); ?>
