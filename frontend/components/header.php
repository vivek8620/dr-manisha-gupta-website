<?php include 'components/meta.php'; ?>

<?php
$currentPage = pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME);
$navItems = [
  ['name' => 'Home',     'link' => './'],
  ['name' => 'About',    'link' => 'about'],
  ['name' => 'Blogs',    'link' => 'blogs'],
];
?>

<header class="w-full absolute top-0 left-0 z-50">

  <!-- Full-width bar -->
  <div class="w-full bg-white/95 backdrop-blur-xl shadow-lg border-b border-white/20">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6">
      <div class="flex items-center justify-between py-4">

        <!-- LOGO -->
        <a href="./"
          class="italic font-semibold tracking-tight leading-none transition duration-300
                  text-[22px] sm:text-[28px] md:text-[32px] lg:text-[36px]
                  bg-gradient-to-r from-brand-sky to-brand-navy bg-clip-text text-transparent font-display">
          Dr. Manisha Gupta
        </a>

        <!-- DESKTOP NAV -->
        <nav class="hidden md:flex items-center gap-6 lg:gap-10">
          <?php foreach ($navItems as $item):
            $isActive = ($currentPage === trim($item['link'], './') || ($currentPage === 'index' && $item['link'] === './'));
          ?>
            <a href="<?= $item['link'] ?>"
              class="relative py-1 text-brand-navyMd text-[15px] font-semibold
                      hover:text-brand-teal transition-colors duration-300
                      <?= $isActive ? 'text-brand-teal active-nav' : '' ?>">
              <?= $item['name'] ?>
              <span class="nav-underline <?= $isActive ? '!w-full' : '' ?>"></span>
            </a>
          <?php endforeach; ?>
        </nav>

        <!-- CTA — same slide-fill hover as hero button -->
        <a href="contact"
          class="hidden md:relative md:overflow-hidden md:inline-flex lg:items-center lg:gap-2
                  bg-[#0b3444] text-white text-sm font-semibold
                  px-5 py-2.5 rounded-full group
                  transition-all duration-300
                  hover:shadow-[0_8px_25px_rgba(14,173,174,0.35)]">

          <span class="relative z-10 flex items-center gap-2 transition-colors duration-300 group-hover:text-white">
            Connect with us
            <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center transition-colors duration-300 group-hover:bg-white/30">
              <svg width="10" height="10" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </span>
          </span>

          <!-- Slide-in teal fill -->
          <span class="absolute inset-0 bg-[#0eadae] translate-x-[-100%] group-hover:translate-x-0
                       transition-transform duration-500 ease-out rounded-full"></span>

        </a>

        <!-- HAMBURGER (animated) -->
        <button id="menuBtn"
          aria-label="Toggle menu"
          class="md:hidden p-2 flex flex-col justify-center items-center w-10 h-10 rounded-xl
                       hover:bg-brand-sky/10 transition-colors duration-200">
          <span class="ham-bar block w-6 h-[2.5px] bg-brand-navyMd rounded-full mb-[5px]"></span>
          <span class="ham-bar block w-6 h-[2.5px] bg-brand-navyMd rounded-full mb-[5px]"></span>
          <span class="ham-bar block w-6 h-[2.5px] bg-brand-navyMd rounded-full"></span>
        </button>

      </div>
    </div>
  </div>

  <!-- MOBILE MENU (slide-down) -->
  <div id="mobileMenu" class="md:hidden bg-white shadow-xl border-t border-gray-100">
    <div class="max-w-[1440px] mx-auto px-4 py-3 flex flex-col">

      <?php foreach ($navItems as $item):
        $isActive = ($currentPage === trim($item['link'], './') || ($currentPage === 'index' && $item['link'] === './'));
      ?>
        <a href="<?= $item['link'] ?>"
          class="group relative py-4 text-brand-navyMd font-medium border-b border-gray-100
                  hover:text-brand-teal transition-colors duration-300
                  <?= $isActive ? 'text-brand-teal' : '' ?>">
          <?= $item['name'] ?>
          <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-brand-sky to-brand-teal rounded-full
                       transition-all duration-300 w-0 group-hover:w-full
                       <?= $isActive ? '!w-full' : '' ?>"></span>
        </a>
      <?php endforeach; ?>

      <a href="contact"
        class="mt-4 mb-2 text-center bg-brand-navy text-white
                py-3 rounded-full font-semibold
                hover:bg-brand-teal transition-colors duration-300">
        Connect with us
      </a>

    </div>
  </div>

</header>

<script>
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');

  menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('is-open');
    mobileMenu.classList.toggle('open');
  });

  document.addEventListener('click', (e) => {
    if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
      menuBtn.classList.remove('is-open');
      mobileMenu.classList.remove('open');
    }
  });
</script>
