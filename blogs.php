<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Latest Digital Marketing Blogs, Tips & Insights | AGDM Academy";
$pageDescription = "Read the latest digital marketing blogs, SEO guides, and social media tips from AGDM Academy experts.";
$pageKeywords = "digital marketing blog, seo checklist 2026, scale meta ads, google ads tips, free marketing resources, digital marketing articles, ai tools for marketing, content strategy guides";
agdm_include_part('header.php');
?>

<!-- HERO SECTION -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1 text-center">
    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">Resources</span>
    <h1 class="display-4 fw-bold mb-3">Our Latest <span class="text-danger">Insights</span></h1>
    <p class="lead text-white-50 mx-auto" style="max-width: 600px;">Read practical insights, case studies, and actionable guides on SEO, paid ads, social media, and digital strategy.</p>
  </div>
  
  <!-- Abstract shape in background -->
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-25" style="width: 200px; height: 200px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
</section>

<!-- BLOGS GRID -->
<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="row g-5">
      <!-- Blog Item 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="SEO Checklist" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-danger bg-opacity-10 text-danger mb-3 align-self-start px-3 py-2 rounded-pill">SEO</span>
            <h5 class="fw-bold mb-3">The Ultimate SEO Checklist for 2026</h5>
            <p class="text-muted flex-grow-1">Actionable on-page and technical SEO checklist to improve your organic rankings faster and dominate the SERPs.</p>
            <a href="blog-seo-checklist" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1533750349088-cd871a92f312?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="Meta Ads Guide" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 align-self-start px-3 py-2 rounded-pill">Paid Ads</span>
            <h5 class="fw-bold mb-3">How to Start Scaling Meta Ads</h5>
            <p class="text-muted flex-grow-1">A beginner-friendly roadmap to launch profitable ad campaigns with a clear funnel structure and optimal ROAS.</p>
            <a href="blog-meta-ads" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="AI Tools" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-success bg-opacity-10 text-success mb-3 align-self-start px-3 py-2 rounded-pill">AI & Tech</span>
            <h5 class="fw-bold mb-3">Top 10 AI Tools for Modern Marketers</h5>
            <p class="text-muted flex-grow-1">Discover the top AI tools to drastically speed up deep research, content planning, ad creatives, and reporting.</p>
            <a href="blog-ai-tools" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 4 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="Content Marketing" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-warning bg-opacity-10 text-warning mb-3 align-self-start px-3 py-2 rounded-pill">Content</span>
            <h5 class="fw-bold mb-3">Mastering Content Marketing in 2026</h5>
            <p class="text-muted flex-grow-1">Learn how to create engaging, valuable content that naturally converts casual readers into loyal brand advocates.</p>
            <a href="#" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 5 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="Data Analytics" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-info bg-opacity-10 text-info mb-3 align-self-start px-3 py-2 rounded-pill">Analytics</span>
            <h5 class="fw-bold mb-3">Demystifying Data Analytics</h5>
            <p class="text-muted flex-grow-1">A comprehensive guide to correctly interpreting your website traffic, user behavior, and conversion tracking.</p>
            <a href="#" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 6 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="Email Marketing" style="height: 240px; object-fit: cover;">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-secondary bg-opacity-10 text-secondary mb-3 align-self-start px-3 py-2 rounded-pill">Email</span>
            <h5 class="fw-bold mb-3">Email Marketing Best Practices</h5>
            <p class="text-muted flex-grow-1">Discover proven strategies to build a massive email list and design newsletter campaigns that actually get clicks.</p>
            <a href="#" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read Article <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Optional Custom Style for Hover Effect -->
    <style>
      .blog-hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .blog-hover-effect:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
      }
      .blog-hover-effect img {
        transition: transform 0.5s ease;
      }
      .blog-hover-effect:hover img {
        transform: scale(1.05);
      }
    </style>
  </div>
</section>

<?php agdm_include_part('footer.php'); ?>
