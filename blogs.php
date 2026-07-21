<?php

require_once __DIR__ . '/data/blogs.php';

$filterCat     = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$allBlogs      = getAllBlogs();
$categories    = getCategoryList();
$recentBlogs   = getFeaturedBlogs(3);

$filteredBlogs = $filterCat
    ? array_values(array_filter($allBlogs, fn($b) => $b['cat'] === $filterCat))
    : $allBlogs;
?>
<?php include 'components/header.php'; ?>

<div class="bg-gray-50">
    <div class="mx-auto bg-white shadow-sm overflow-hidden">

        <!-- HERO -->
        <section class="relative min-h-[220px] sm:min-h-[280px] lg:min-h-[320px] flex items-center overflow-hidden bg-cover bg-center">
            <div class="absolute inset-0 bg-[#062D42]/95 z-0">
                <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-teal/20 rounded-full blur-[120px] -mr-40 -mt-40"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-[#008bb7]/20 rounded-full blur-[120px] -ml-40 -mb-40"></div>
            </div>
            <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 w-full h-full flex flex-col justify-center pt-20 pb-8">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-semibold text-white animate-rise tracking-tight leading-tight">
                    Our <span class="text-brand-teal">Blogs</span>
                </h1>
                <div class="h-1 w-16 bg-gradient-to-r from-[#008bb7] to-[#14b8a6] mt-3 rounded-full"></div>
                <nav class="mt-4 flex items-center gap-3 text-xs font-medium animate-rise [animation-delay:150ms]">
                    <a href="./" class="text-white/50 hover:text-white transition-colors">Home</a>
                    <span class="text-white/20">/</span>
                    <span class="text-white border-b border-brand-teal/50 pb-0.5">Blogs</span>
                </nav>
            </div>
        </section>

        <div class="h-1.5 w-full bg-gradient-to-r from-[#008bb7] to-[#14b8a6]"></div>

        <!-- MAIN CONTENT -->
        <main class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="flex flex-col lg:flex-row gap-10">

                <!-- BLOG GRID -->
                <div class="flex-1 min-w-0">

                    <!-- Active filter indicator -->
                    <?php if ($filterCat): ?>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="text-sm text-gray-500">Showing:</span>
                            <span class="inline-flex items-center gap-2 bg-[#0eadae]/10 text-[#0eadae] text-xs font-bold px-3 py-1.5 rounded-full border border-[#0eadae]/20">
                                <?= htmlspecialchars($filterCat) ?>
                                <a href="blogs" class="hover:text-[#062D42] transition-colors text-base leading-none">&times;</a>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 lg:gap-6" id="blogGrid">
                        <?php foreach ($filteredBlogs as $post):
                            $articleUrl = 'blog/' . urlencode($post['slug']);
                        ?>
                            <article class="blog-card bg-white border-[1.5px] border-gray-200 rounded-2xl overflow-hidden flex flex-col cursor-pointer
                               transition-all duration-300 hover:-translate-y-1
                               hover:shadow-[0_24px_56px_rgba(14,173,174,0.13),0_4px_18px_rgba(14,173,174,0.08)]
                               hover:border-[#0eadae]"
                                data-category="<?= htmlspecialchars($post['cat']) ?>"
                                data-title="<?= strtolower(htmlspecialchars($post['title'])) ?>"
                                data-excerpt="<?= strtolower(htmlspecialchars($post['excerpt'])) ?>"
                                data-url="<?= htmlspecialchars($articleUrl) ?>"
                                onclick="goToArticle(this)">

                                <!-- Image -->
                                <div class="relative h-48 sm:h-52 overflow-hidden">
                                    <img src="<?= htmlspecialchars($post['img']) ?>"
                                         alt="<?= htmlspecialchars($post['title']) ?>"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                         loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/25 to-transparent"></div>
                                    <?php if (!empty($post['badge'])): ?>
                                        <span class="absolute top-3 right-3 bg-[#062D42] text-white text-[10px] font-black tracking-wider uppercase px-3 py-1 rounded-full">
                                            <?= htmlspecialchars($post['badge']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="absolute bottom-3 left-3 cat-pill">
                                        <?= htmlspecialchars($post['cat']) ?>
                                    </span>
                                </div>

                                <!-- Body -->
                                <div class="p-4 sm:p-5 flex flex-col flex-1">
                                    <p class="text-[11px] text-gray-400 mb-2 flex items-center gap-1.5">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <?= htmlspecialchars($post['date']) ?>
                                        <span class="text-gray-300">·</span>
                                        <?= htmlspecialchars($post['read']) ?>
                                    </p>
                                    <h3 class="text-[#062D42] text-base sm:text-lg font-bold leading-snug mb-2 line-clamp-2 hover:text-[#0eadae] transition-colors">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </h3>
                                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-4 flex-1">
                                        <?= htmlspecialchars($post['excerpt']) ?>
                                    </p>
                                    <div class="flex items-center justify-end pt-3 border-t border-gray-100">
                                        <span class="flex items-center gap-1 text-[#0eadae] text-xs font-bold">
                                            Read
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Empty state -->
                    <?php if (empty($filteredBlogs)): ?>
                        <div class="text-center py-20">
                            <div class="w-16 h-16 bg-[#0eadae]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-[#0eadae]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-[#062D42] font-semibold text-lg">No articles found</p>
                            <p class="text-gray-400 text-sm mt-1">Try selecting a different category.</p>
                            <a href="blogs" class="inline-block mt-4 text-[#0eadae] font-bold text-sm hover:underline">View all articles →</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- SIDEBAR -->
                <aside class="w-full lg:w-[290px] xl:w-[310px] flex-shrink-0">
                    <div class="lg:sticky lg:top-6 space-y-5">

                        <!-- Categories — built dynamically from data -->
                        <div class="sidebar-widget">
                            <h3 class="text-[#062D42] font-['Playfair_Display'] font-black text-lg mb-4">All Categories</h3>
                            <ul class="space-y-1">
                                <?php foreach ($categories as $i => $c):
                                    $isActive = ($filterCat === $c['slug']) || ($filterCat === '' && $c['slug'] === '');
                                ?>
                                    <li>
                                        <a href="blogs<?= $c['slug'] ? '?cat=' . urlencode($c['slug']) : '' ?>"
                                           class="flex items-center justify-between py-2 px-2 rounded-lg text-sm font-medium transition-all duration-200
                                                  <?= $isActive ? 'text-[#0eadae] bg-[#0eadae]/8 font-bold' : 'text-[#062D42] hover:text-[#0eadae] hover:bg-[#0eadae]/5' ?>
                                                  group">
                                            <span class="flex items-center gap-2">
                                                <?php if ($i > 0): ?>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0eadae] <?= $isActive ? 'opacity-100' : 'opacity-50 group-hover:opacity-100' ?> transition-opacity"></span>
                                                <?php else: ?>
                                                    <span class="w-1.5 h-1.5 rounded-full <?= $isActive ? 'bg-[#0eadae]' : 'bg-gray-300' ?>"></span>
                                                <?php endif; ?>
                                                <?= htmlspecialchars($c['name']) ?>
                                            </span>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full transition-colors
                                                         <?= $isActive ? 'bg-[#0eadae]/15 text-[#0eadae]' : 'bg-gray-100 text-gray-500 group-hover:bg-[#0eadae]/10 group-hover:text-[#0eadae]' ?>">
                                                <?= $c['count'] ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Recent Blogs — from data -->
                        <div class="sidebar-widget">
                            <h3 class="text-[#062D42] font-['Playfair_Display'] font-black text-lg mb-4">Recent Blogs</h3>
                            <div class="space-y-3">
                                <?php foreach ($recentBlogs as $rp): ?>
                                    <a href="blog/<?= urlencode($rp['slug']) ?>"
                                       class="latest-row flex items-start gap-3 p-2 -mx-2 rounded-xl">
                                        <div class="w-14 h-12 sm:w-16 sm:h-14 rounded-xl overflow-hidden flex-shrink-0">
                                            <img src="<?= htmlspecialchars($rp['img']) ?>"
                                                 alt="<?= htmlspecialchars($rp['title']) ?>"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[#062D42] text-xs font-semibold leading-snug line-clamp-2 hover:text-[#0eadae] transition-colors">
                                                <?= htmlspecialchars($rp['title']) ?>
                                            </p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[#0eadae] text-[10px] font-bold"><?= htmlspecialchars($rp['cat']) ?></span>
                                                <span class="text-gray-400 text-[10px]"><?= htmlspecialchars($rp['date']) ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="bg-[#062D42] rounded-2xl p-5 sm:p-6 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-[#0eadae] opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="w-11 h-11 bg-[#0eadae]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-5 h-5 text-[#0eadae]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="font-['Playfair_Display'] text-white font-black text-lg mb-2 leading-tight">Book a Consultation</h4>
                            <p class="text-white/60 text-xs leading-relaxed mb-4">Have health concerns? Get personalised advice from Dr. Manisha Gupta.</p>
                            <a href="contact"
                               class="inline-flex items-center gap-2 bg-[#0eadae] hover:bg-[#0a9596] text-white text-xs font-bold px-5 py-2.5 rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-[#0eadae]/30">
                                Connect with us
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </aside>
            </div>
        </main>

    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    function goToArticle(card) {
        var url = card.getAttribute('data-url');
        if (url) window.location.href = url;
    }
</script>
