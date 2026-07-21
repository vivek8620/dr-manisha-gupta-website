<?php
require_once __DIR__ . '/data/blogs.php';
$featuredBlogs = getFeaturedBlogs(3);
?>

<section class="py-14 bg-gradient-to-b from-white via-[#e6f0f5] to-white">
  <div class="max-w-[1440px] px-6 mx-auto">

    <!-- Heading -->
    <div class="text-center mb-10 px-4">
      <h2 class="section-heading text-4xl md:text-6xl font-semibold leading-tight font-fraunces tracking-tight">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#58A9E2] to-[#064854]">
          Health Articles
        </span>
      </h2>
      <div class="w-20 h-1.5 bg-gradient-to-r from-[#74C2F9] to-[#064854] mx-auto mt-5 rounded-full"></div>
      <p class="text-gray-500 mt-4 text-sm">Latest health tips and expert insights from our specialists</p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <?php foreach ($featuredBlogs as $blog): ?>

        <a href="blog/<?= urlencode($blog['slug']) ?>"
          class="group bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition-all duration-500 hover:-translate-y-1 flex flex-col cursor-pointer">

          <!-- IMAGE -->
          <div class="relative w-full overflow-hidden" style="padding-top: 56.25%;">
            <img
              src="<?= htmlspecialchars($blog['img']) ?>"
              alt="<?= htmlspecialchars($blog['title']) ?>"
              width="800"
              height="450"
              class="absolute inset-0 w-full h-full object-cover object-center transition duration-700 group-hover:scale-105"
              loading="lazy"
              decoding="async">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
            <div class="absolute top-3 left-3">
              <span class="text-[10px] font-semibold tracking-wide uppercase px-2.5 py-1 rounded-full <?= $blog['cat_color'] ?> shadow-sm">
                <?= htmlspecialchars($blog['cat']) ?>
              </span>
            </div>
            <?php if (!empty($blog['badge'])): ?>
              <span class="absolute top-3 right-3 bg-[#062D42] text-white text-[10px] font-black tracking-wider uppercase px-3 py-1 rounded-full">
                <?= htmlspecialchars($blog['badge']) ?>
              </span>
            <?php endif; ?>
          </div>

          <!-- CONTENT -->
          <div class="p-4 flex flex-col flex-1">
            <p class="text-[11px] text-gray-400 mb-1.5 flex items-center gap-1">
              <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <?= htmlspecialchars($blog['date']) ?>
            </p>

            <h3 class="text-brand-navy font-bold text-base leading-snug mb-1.5 group-hover:text-brand-teal transition-colors duration-300 line-clamp-2">
              <?= htmlspecialchars($blog['title']) ?>
            </h3>

            <div class="flex flex-col flex-1">
              <p class="text-gray-500 text-xs leading-relaxed mb-2 line-clamp-3">
                <?= htmlspecialchars($blog['excerpt']) ?>
              </p>

              <div class="border-t border-gray-100 pt-2 mt-auto">
                <span class="inline-flex items-center gap-1.5 text-brand-navy font-semibold text-xs group-hover:text-brand-teal transition-all duration-300">
                  Read More
                  <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">→</span>
                </span>
              </div>
            </div>
          </div>

        </a>

      <?php endforeach; ?>
    </div>

    <!-- View All Blogs CTA -->
    <div class="text-center mt-10">
      <a href="blogs"
        class="inline-flex items-center gap-2 bg-[#062D42] text-white text-sm font-semibold px-6 py-3 rounded-full
                transition-all duration-300 hover:bg-[#0eadae] hover:shadow-lg hover:shadow-[#0eadae]/30">
        View All Blogs
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
        </svg>
      </a>
    </div>

  </div>
</section>
