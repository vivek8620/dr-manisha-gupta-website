<?php

if (!isset($conn)) {
  require_once __DIR__ . '/../config.php';
}


// FUNCTION ONLY IF NOT EXISTS
if (!function_exists('getSettingValue')) {

  function getSettingValue($conn, $key, $default = '')
  {
    $stmt = $conn->prepare("
            SELECT setting_value
            FROM settings
            WHERE setting_key = ?
            LIMIT 1
        ");

    $stmt->bind_param("s", $key);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      return $row['setting_value'];
    }

    return $default;
  }
}

// GET SETTINGS
$site_phone = getSettingValue(
  $conn,
  'site_phone',
  '+91 9417555092'
);

$site_email = getSettingValue(
  $conn,
  'site_email',
  'manisha_guptaus@yahoo.com'
);

$site_address = getSettingValue(
  $conn,
  'site_address',
  'Sector 77, Sahibzada Ajit Singh Nagar, Punjab 140308, India'
);

$social_instagram = getSettingValue(
  $conn,
  'social_instagram',
  'https://www.instagram.com/consultantmedicinemanisha/'
);

$social_facebook = getSettingValue(
  $conn,
  'social_facebook',
  'https://www.facebook.com/manisha.gupta.3956'
);

$social_youtube = getSettingValue(
  $conn,
  'social_youtube',
  ''
);

$social_linkedin = getSettingValue(
  $conn,
  'social_linkedin',
  ''
);

?>

<footer>
  <div class="bg-[#062D42F2]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 py-10 md:py-14 grid sm:grid-cols-2 lg:grid-cols-[1.3fr_0.7fr_0.8fr_1.2fr] gap-8 md:gap-10">

      <!-- Brand -->
      <div>
        <div class="text-white text-[22px] md:text-[28px] font-semibold mb-1">Dr. Manisha Gupta</div>
        <div class="text-sm italic text-brand-gold mb-4">MBBS, MD – General Physician</div>
        <p class="text-base leading-relaxed text-white/85 xl:pr-12">Your Trusted Clinician for Illness and Long-Term Wellness. Delivering expert care in cardiology, diabetology, gastric health, and thyroid management.</p>
      </div>

      <!-- Quick Links -->
      <div>
        <div class="text-lg font-semibold text-white mb-4">Quick Links</div>
        <ul class="text-base text-white space-y-3">
          <li>
            <a href="./"
              class="relative inline-block text-white hover:text-brand-teal transition-colors duration-300
            after:content-[''] after:absolute after:left-0 after:-bottom-1
            after:h-[2px] after:w-0 after:rounded-full
            after:bg-gradient-to-r after:from-brand-sky after:to-brand-teal
            after:transition-all after:duration-300
            hover:after:w-full">
              Home
            </a>
          </li>

          <li>
            <a href="about"
              class="relative inline-block text-white hover:text-brand-teal transition-colors duration-300
            after:content-[''] after:absolute after:left-0 after:-bottom-1
            after:h-[2px] after:w-0 after:rounded-full
            after:bg-gradient-to-r after:from-brand-sky after:to-brand-teal
            after:transition-all after:duration-300
            hover:after:w-full">
              About
            </a>
          </li>

          <li>
            <a href="blogs"
              class="relative inline-block text-white hover:text-brand-teal transition-colors duration-300
            after:content-[''] after:absolute after:left-0 after:-bottom-1
            after:h-[2px] after:w-0 after:rounded-full
            after:bg-gradient-to-r after:from-brand-sky after:to-brand-teal
            after:transition-all after:duration-300
            hover:after:w-full">
              Blogs
            </a>
          </li>

          <li>
            <a href="contact"
              class="relative inline-block text-white hover:text-brand-teal transition-colors duration-300
            after:content-[''] after:absolute after:left-0 after:-bottom-1
            after:h-[2px] after:w-0 after:rounded-full
            after:bg-gradient-to-r after:from-brand-sky after:to-brand-teal
            after:transition-all after:duration-300
            hover:after:w-full">
              Contact
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <div class="text-lg font-semibold text-white mb-4">Contact Us</div>
        <div class="text-base text-white space-y-4">
          <div class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-1 flex-shrink-0 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
              <polyline points="22,6 12,13 2,6" />
            </svg>
            <span class="text-white/85 text-sm leading-relaxed">
              <a href="mailto:<?php echo htmlspecialchars($site_email); ?>" class="">
                <?php echo htmlspecialchars($site_email); ?>
              </a>
            </span>
          </div>
          <div class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-1 flex-shrink-0 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5 19.79 19.79 0 01.01 2.86 2 2 0 012 .68h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.49a16 16 0 006.29 6.29l1.42-1.42a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
            </svg>
            <span class="text-white/85 text-sm">
              <a href="tel:<?php echo preg_replace('/\s+/', '', $site_phone); ?>" class="">
                <?php echo htmlspecialchars($site_phone); ?>
              </a>
            </span>
          </div>
          <div class="flex items-start gap-3">
            <svg class="w-4 h-4 mt-1 flex-shrink-0 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <span class="text-white/85 text-sm">
              <a href="https://www.google.com/maps/search/<?php echo urlencode($site_address); ?>"
                target="_blank"
                class="">
                <?php echo htmlspecialchars($site_address); ?>
              </a>
            </span>
          </div>
        </div>
      </div>

      <!-- Get in Touch -->
      <div>
        <div class="text-lg font-semibold text-white mb-4">
          Get in Touch
        </div>

        <p class="text-white/70 text-sm mb-5">
          We'd love to connect with you. Reach out anytime for appointments or queries.
        </p>

        <div class="flex gap-3">

          <?php if (!empty($social_instagram)): ?>
          <a href="<?php echo htmlspecialchars($social_instagram); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Visit Dr. Manisha Gupta on Instagram"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
            </svg>
          </a>
          <?php endif; ?>

          <?php if (!empty($social_facebook)): ?>
          <a href="<?php echo htmlspecialchars($social_facebook); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Visit Dr. Manisha Gupta on Facebook"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
          </a>
          <?php endif; ?>

          <?php if (!empty($social_youtube)): ?>
          <a href="<?php echo htmlspecialchars($social_youtube); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Visit Dr. Manisha Gupta on YouTube"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
              <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.97C18.88 4 12 4 12 4s-6.88 0-8.59.45a2.78 2.78 0 0 0-1.95 1.97A29.94 29.94 0 0 0 1 12a29.94 29.94 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.97C5.12 20 12 20 12 20s6.88 0 8.59-.45a2.78 2.78 0 0 0 1.95-1.97A29.94 29.94 0 0 0 23 12a29.94 29.94 0 0 0-.46-5.58z" />
              <path d="M10 15l5-3-5-3v6z" />
            </svg>
          </a>
          <?php endif; ?>

          <?php if (!empty($social_linkedin)): ?>
          <a href="<?php echo htmlspecialchars($social_linkedin); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Visit Dr. Manisha Gupta on LinkedIn"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z" />
              <path d="M2 9h4v12H2z" />
              <circle cx="4" cy="4" r="2" />
            </svg>
          </a>
          <?php endif; ?>

          <!-- Phone -->
          <a href="tel:<?php echo preg_replace('/\s+/', '', $site_phone); ?>"
            aria-label="Call Dr. Manisha Gupta"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5 19.79 19.79 0 01.01 2.86 2 2 0 012 .68h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.49a16 16 0 006.29 6.29l1.42-1.42a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
            </svg>
          </a>

          <!-- Location (Google Maps) -->
          <a href="https://www.google.com/maps/search/<?php echo urlencode($site_address); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Open Dr. Manisha Gupta clinic location on Google Maps"
            class="w-[38px] h-[38px] rounded-full border border-white/30 flex items-center justify-center
              hover:bg-white/10 hover:border-white/60 transition-all duration-300">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
          </a>

        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/20 py-5 text-center">
      <p class="text-[13px] text-white font-sans">
        © 2026 Dr. Manisha Gupta. All rights reserved. Crafted with care.
      </p>
    </div>
  </div>
</footer>
