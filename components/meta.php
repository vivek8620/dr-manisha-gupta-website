<?php
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$origin = $scheme . '://' . $host;
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if (isset($_GET['slug']) && basename($_SERVER['SCRIPT_NAME']) === 'blogdetails.php') {
  $canonicalPath = ($basePath ?: '') . '/blog/' . rawurlencode(trim($_GET['slug']));
} elseif (isset($_GET['slug']) && basename($_SERVER['SCRIPT_NAME']) === 'article.php') {
  $canonicalPath = ($basePath ?: '') . '/blogs';
} elseif (isset($_GET['slug']) && basename($_SERVER['SCRIPT_NAME']) === 'health-article.php') {
  $canonicalPath = ($basePath ?: '') . '/health-article/' . rawurlencode(trim($_GET['slug']));
} else {
  $canonicalPath = preg_replace('#/index\.php$#i', '/', $requestPath);
  $canonicalPath = preg_replace('#\.php$#i', '', $canonicalPath);
}

$canonicalPath = '/' . ltrim($canonicalPath, '/');
if ($canonicalPath !== '/') {
  $canonicalPath = rtrim($canonicalPath, '/');
}
$canonicalUrl = $origin . $canonicalPath;
$scriptName = basename($_SERVER['SCRIPT_NAME']);

$defaultTitle = 'Dr Manisha Gupta - General Physician & Internal Medicine Specialist';
$defaultDescription = 'Dr. Manisha Gupta is an MBBS, MD General Physician and Internal Medicine specialist offering expert care in cardiology, diabetology, gastric health, thyroid management, and long-term wellness.';
$defaultImage = 'images/Banner/Banner1.jpg';
$defaultLogo = 'images/profile pic/manisha.png';

$pageTitle = $pageTitle ?? $defaultTitle;
$pageDescription = $pageDescription ?? $defaultDescription;
$pageKeywords = $pageKeywords ?? 'Dr Manisha Gupta, general physician, internal medicine specialist, Mohali doctor, cardiology care, diabetes specialist, thyroid doctor, gastric care';
$pageImage = $pageImage ?? $defaultImage;
$ogType = $ogType ?? 'website';

if (isset($blog) && is_array($blog)) {
  $pageTitle = ($blog['title'] ?? 'Health Blog') . ' | Dr Manisha Gupta';
  $pageDescription = $blog['excerpt'] ?? $defaultDescription;
  $pageImage = $blog['img'] ?? $defaultImage;
  $pageKeywords = !empty($blog['tags']) && is_array($blog['tags'])
    ? implode(', ', array_merge($blog['tags'], ['Dr Manisha Gupta', 'health blog']))
    : $pageKeywords;
  $ogType = 'article';
} elseif (isset($article) && is_array($article)) {
  $pageTitle = ($article['title'] ?? 'Health Article') . ' | Dr Manisha Gupta';
  $pageDescription = $article['excerpt'] ?? $article['intro'] ?? $defaultDescription;
  $pageImage = $article['img'] ?? $article['image'] ?? $defaultImage;
  $ogType = 'article';
} elseif ($scriptName === 'about.php') {
  $pageTitle = 'About Dr Manisha Gupta | Internal Medicine Specialist';
  $pageDescription = 'Learn about Dr. Manisha Gupta, MBBS, MD, Senior Consultant in Internal Medicine with experience in cardiology, diabetes, gastric care, thyroid disorders, and preventive health.';
} elseif ($scriptName === 'blogs.php') {
  $pageTitle = 'Health Blogs | Dr Manisha Gupta';
  $pageDescription = 'Read health articles by Dr. Manisha Gupta on diabetes, thyroid disorders, cardiac care, gastric health, weight management, and preventive medicine.';
} elseif ($scriptName === 'contact.php') {
  $pageTitle = 'Contact Dr Manisha Gupta | Book a Consultation';
  $pageDescription = 'Contact Dr. Manisha Gupta for appointments and consultations for internal medicine, diabetes, thyroid, cardiac, gastric, and preventive health care.';
}

$absoluteImageUrl = preg_match('#^https?://#i', $pageImage)
  ? $pageImage
  : $origin . ($basePath ?: '') . '/' . ltrim($pageImage, '/');
$absoluteImageUrl = str_replace(' ', '%20', $absoluteImageUrl);
$absoluteLogoUrl = $origin . ($basePath ?: '') . '/' . ltrim($defaultLogo, '/');
$absoluteLogoUrl = str_replace(' ', '%20', $absoluteLogoUrl);

$metaTitle = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
$metaDescription = htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8');
$metaKeywords = htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8');
$metaCanonical = htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8');
$metaImage = htmlspecialchars($absoluteImageUrl, ENT_QUOTES, 'UTF-8');
$metaLogo = htmlspecialchars($absoluteLogoUrl, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?= $basePath ?>/">
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDescription ?>">
  <meta name="keywords" content="<?= $metaKeywords ?>">
  <meta name="author" content="Dr. Manisha Gupta">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="<?= $metaCanonical ?>">
  <link rel="preload" as="image" href="<?= $metaImage ?>" fetchpriority="high">

  <meta property="og:locale" content="en_IN">
  <meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:site_name" content="Dr. Manisha Gupta">
  <meta property="og:title" content="<?= $metaTitle ?>">
  <meta property="og:description" content="<?= $metaDescription ?>">
  <meta property="og:url" content="<?= $metaCanonical ?>">
  <meta property="og:image" content="<?= $metaImage ?>">
  <meta property="og:logo" content="<?= $metaLogo ?>">
  <meta property="og:image:alt" content="<?= $metaTitle ?>">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $metaTitle ?>">
  <meta name="twitter:description" content="<?= $metaDescription ?>">
  <meta name="twitter:image" content="<?= $metaImage ?>">

  <!-- Favicon -->
  <link rel="icon" href="<?= $basePath ?>/images/profile pic/manisha.png" type="image/png">

  <!-- Google Fonts: Poppins + Fraunces -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,600;1,9..144,700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
  <noscript>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,600;1,9..144,700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  </noscript>

  <!-- Font Awesome -->
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  </noscript>

  <!-- Compiled Tailwind CSS -->
  <link rel="stylesheet" href="<?= $basePath ?>/assets/css/styles.css">

  <!-- Base styles (font + scroll behaviour only — no layout) -->
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* Navbar underline animation helper */
    .nav-underline {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 2px;
      width: 0;
      background: linear-gradient(to right, #58A9E2, #0eadae);
      border-radius: 9999px;
      transition: width 0.3s ease;
    }

    a:hover .nav-underline,
    a.active-nav .nav-underline {
      width: 100%;
    }

    a.active-nav .nav-underline {
      width: 100%;
    }

    /* Mobile menu slide animation */
    #mobileMenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s cubic-bezier(.22, 1, .36, 1), opacity 0.3s ease;
      opacity: 0;
    }

    #mobileMenu.open {
      max-height: 600px;
      opacity: 1;
    }

    /* Hamburger animation */
    .ham-bar {
      transition: all 0.3s ease;
      transform-origin: center;
    }

    #menuBtn.is-open .ham-bar:nth-child(1) {
      transform: translateY(8px) rotate(45deg);
    }

    #menuBtn.is-open .ham-bar:nth-child(2) {
      opacity: 0;
      transform: scaleX(0);
    }

    #menuBtn.is-open .ham-bar:nth-child(3) {
      transform: translateY(-8px) rotate(-45deg);
    }

    /* Footer link hover underline – same animation */
    .footer-link {
      position: relative;
      display: inline-block;
    }

    .footer-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #20C997;
      border-radius: 9999px;
      transition: width 0.3s ease;
    }

    .footer-link:hover::after {
      width: 100%;
    }

    /* Section heading consistency */
    .section-heading {
      font-family: 'Poppins', sans-serif;
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      line-height: 1.1;
      letter-spacing: -0.02em;
    }

    .section-heading-gradient {
      background: linear-gradient(to right, #58A9E2, #042A3F);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* 3D card helpers for specialties */
    .perspective-1000 {
      perspective: 1000px;
    }

    .transform-style-3d {
      transform-style: preserve-3d;
    }

    .rotate-y-12 {
      transform: rotateY(-5deg) rotateX(2deg);
    }

    /* Blog category pill */
    .cat-pill {
      display: inline-block;
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #0eadae;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(14, 173, 174, 0.25);
      padding: 3px 10px;
      border-radius: 9999px;
      line-height: 1.6;
    }

    /* Sidebar widgets */
    .sidebar-widget {
      background: #fff;
      border: 1.5px solid #f1f5f9;
      border-radius: 1rem;
      padding: 1.25rem;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .sidebar-cat-btn {
      transition: color 0.2s;
      border-radius: 0.5rem;
    }

    .sidebar-cat-btn.active {
      color: #0eadae;
      font-weight: 700;
    }

    .cat-link:hover {
      color: #0eadae;
    }

    .latest-row {
      border-radius: 0.75rem;
      transition: background 0.2s;
    }

    .latest-row:hover {
      background: #f8fafc;
    }

    /* rise animations */
    .rise {
      animation: riseIn 0.55s cubic-bezier(.22, 1, .36, 1) both;
    }

    .rise-2 {
      animation-delay: 0.05s;
    }

    .rise-3 {
      animation-delay: 0.12s;
    }

    .rise-4 {
      animation-delay: 0.20s;
    }

    .rise-5 {
      animation-delay: 0.28s;
    }

    /* Article body styles */
    .article-body h2 {
      font-size: 1.35rem;
      font-weight: 700;
      color: #062D42;
      margin: 2rem 0 0.75rem;
      line-height: 1.35;
    }

    .article-body p {
      color: #4B5563;
      line-height: 1.85;
      margin-bottom: 1.1rem;
      font-size: 1rem;
    }

    .article-body ul {
      list-style: none;
      padding: 0;
      margin-bottom: 1.25rem;
    }

    .article-body ul li {
      position: relative;
      padding-left: 1.4rem;
      color: #4B5563;
      margin-bottom: 0.6rem;
      line-height: 1.75;
    }

    .article-body ul li::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0.6rem;
      width: 0.45rem;
      height: 0.45rem;
      border-radius: 50%;
      background: #0eadae;
    }

    .intro-para {
      font-size: 1.08rem;
      color: #374151;
      font-weight: 500;
      line-height: 1.9;
      margin-bottom: 1.5rem;
      border-left: 3px solid #0eadae;
      padding-left: 1rem;
    }

    .callout {
      background: #f0fdff;
      border: 1.5px solid #99f6e4;
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
      margin: 1.25rem 0;
      font-size: 0.95rem;
      color: #374151;
    }

    .conclusion-para {
      background: linear-gradient(135deg, #062D42, #0a4060);
      color: #fff;
      border-radius: 1rem;
      padding: 1.25rem 1.5rem;
      margin-top: 2rem;
      font-size: 0.95rem;
      line-height: 1.75;
    }

    .share-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.45rem 1rem;
      border-radius: 9999px;
      border: 1.5px solid;
      transition: all 0.2s;
    }

    .toc-link {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.45rem 0.5rem;
      font-size: 0.8rem;
      color: #374151;
      border-radius: 0.4rem;
      margin-bottom: 0.25rem;
      transition: all 0.2s;
      text-decoration: none;
    }

    .toc-link:hover {
      background: #f0fdff;
      color: #0eadae;
    }

    #readingProgress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3px;
      background: linear-gradient(90deg, #0eadae, #008bb7);
      z-index: 9999;
      width: 0;
      transition: width 0.1s;
    }

    /* Contact cards */
    .contact-card {
      transition: all 0.3s ease;
    }

    .icon-circle {
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    /* rise animations extra variants */
    .rise-1 {
      animation-delay: 0.0s;
    }

    .rise-6 {
      animation-delay: 0.36s;
    }

    /* dot-bg helper for contact page */
    .dot-bg {
      background-image: radial-gradient(#062D42 0.5px, transparent 0.5px);
      background-size: 22px 22px;
      background-color: #f8fafc;
    }

    /* ── WhatsApp Floating Button ── */
    .whatsapp-float {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 56px;
      height: 56px;
      background: #25D366;
      border-radius: 50%;
      box-shadow: 0 4px 20px rgba(37, 211, 102, 0.45), 0 2px 8px rgba(0, 0, 0, 0.15);
      text-decoration: none;
      transition: transform 0.3s cubic-bezier(.22, 1, .36, 1), box-shadow 0.3s ease;
      animation: waPulse 2.5s ease-in-out infinite;
    }

    .whatsapp-float:hover {
      transform: scale(1.12);
      box-shadow: 0 6px 28px rgba(37, 211, 102, 0.6), 0 4px 12px rgba(0, 0, 0, 0.18);
      animation: none;
    }

    .whatsapp-float svg {
      width: 30px;
      height: 30px;
      fill: #fff;
    }

    @keyframes waPulse {

      0%,
      100% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.45), 0 2px 8px rgba(0, 0, 0, 0.15);
      }

      50% {
        box-shadow: 0 4px 32px rgba(37, 211, 102, 0.75), 0 0 0 8px rgba(37, 211, 102, 0.12);
      }
    }

    @media (max-width: 640px) {
      .whatsapp-float {
        bottom: 18px;
        right: 18px;
        width: 50px;
        height: 50px;
      }

      .whatsapp-float svg {
        width: 26px;
        height: 26px;
      }
    }
  </style>
</head>

<body class="font-sans antialiased text-brand-navyMd">

  <!-- ── Floating WhatsApp Button (visible on all pages/devices) ── -->
  <a href="https://wa.me/919417555092"
    target="_blank"
    rel="noopener noreferrer"
    class="whatsapp-float"
    aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
      <path d="M16.004 2C8.28 2 2 8.28 2 16.004c0 2.478.65 4.8 1.784 6.82L2 30l7.368-1.752A13.94 13.94 0 0016.004 30C23.72 30 30 23.72 30 16.004 30 8.28 23.72 2 16.004 2zm0 25.6a11.56 11.56 0 01-5.896-1.612l-.424-.252-4.372 1.04 1.072-4.248-.276-.44A11.518 11.518 0 014.4 16.004C4.4 9.608 9.608 4.4 16.004 4.4c6.392 0 11.596 5.208 11.596 11.604C27.6 22.4 22.4 27.6 16.004 27.6zm6.356-8.672c-.348-.176-2.06-1.016-2.38-1.132-.32-.116-.552-.176-.784.176-.232.348-.9 1.132-1.104 1.364-.2.232-.404.26-.752.088-.348-.176-1.472-.544-2.804-1.728-1.036-.924-1.736-2.064-1.94-2.412-.2-.348-.02-.536.152-.708.156-.156.348-.408.52-.612.176-.2.232-.348.348-.58.116-.232.06-.436-.028-.612-.088-.176-.784-1.892-1.076-2.592-.284-.68-.572-.588-.784-.6-.2-.008-.432-.012-.664-.012a1.272 1.272 0 00-.924.432c-.316.348-1.212 1.184-1.212 2.888s1.24 3.352 1.412 3.584c.176.232 2.44 3.728 5.912 5.228.824.356 1.468.568 1.972.728.828.264 1.58.228 2.176.14.664-.1 2.06-.844 2.348-1.66.292-.816.292-1.516.204-1.66-.084-.14-.316-.228-.664-.404z" />
    </svg>
  </a>