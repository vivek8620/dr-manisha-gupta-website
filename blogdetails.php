<?php

require_once __DIR__ . '/data/blogs.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$blog = getBlogBySlug($slug);

if (!$blog) {
    header('Location: blogs');
    exit;
}

$related    = getRelatedBlogs($blog['id'], $blog['cat'], 3);
$categories = getCategoryList();
$recent     = getFeaturedBlogs(3);
?>
<?php include 'components/header.php'; ?>

<!-- Reading progress bar -->
<div id="readingProgress" style="position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#0eadae,#008bb7);z-index:9999;width:0;transition:width 0.1s;"></div>
<style>
    .prose-content h2,
    .prose-content h3 { color:#042A3F; font-weight:800; margin:2rem 0 1rem; line-height:1.25; }
    .prose-content h2 { font-size:1.55rem; }
    .prose-content h3 { font-size:1.25rem; }
    .prose-content p { margin:0 0 1.25rem; }
    .prose-content ul,
    .prose-content ol { margin:0 0 1.5rem 1.25rem; padding-left:1rem; }
    .prose-content li { margin:0.55rem 0; }
    .prose-content img { max-width:100%; height:auto; border-radius:1rem; margin:1.5rem 0; }
    .prose-content blockquote { border-left:4px solid #0eadae; background:#f0fafa; border-radius:0.75rem; padding:1rem 1.25rem; margin:1.5rem 0; color:#042A3F; }
</style>

<!-- HERO -->
<section class="relative min-h-[220px] sm:min-h-[280px] lg:min-h-[320px] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-[#062D42]/95 z-0">
        <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-[#0eadae]/20 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#008bb7]/20 rounded-full blur-[120px] -ml-40 -mb-40"></div>
    </div>
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 flex flex-col justify-center pt-24 pb-10" style="max-width: 1440px; margin: 0 auto;">
        <span class="inline-block w-fit text-xs font-bold uppercase tracking-[0.2em] px-3 py-1 rounded-full bg-[#0eadae]/20 text-[#0eadae] mb-3">
            <?= htmlspecialchars($blog['cat']) ?>
        </span>
        <h1 class="text-xl sm:text-2xl lg:text-4xl font-semibold text-white leading-tight tracking-tight mb-3 max-w-4xl">
            <?= htmlspecialchars($blog['title']) ?>
        </h1>
        <div class="h-1 w-14 bg-gradient-to-r from-[#008bb7] to-[#14b8a6] rounded-full mb-4"></div>
        <div class="flex items-center gap-4 text-xs text-white/60 mb-4">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?= htmlspecialchars($blog['date']) ?>
            </span>

            <span><?= htmlspecialchars($blog['author']) ?></span>
        </div>
        <nav class="flex items-center gap-2 text-xs font-medium">
            <a href="./" class="text-white/50 hover:text-white transition-colors">Home</a>
            <span class="text-white/20">/</span>
            <a href="blogs" class="text-white/50 hover:text-white transition-colors">Blogs</a>
            <span class="text-white/20">/</span>
            <span class="text-white/80 line-clamp-1 max-w-[200px]"><?= htmlspecialchars($blog['title']) ?></span>
        </nav>
    </div>
</section>

<div class="h-1.5 w-full bg-gradient-to-r from-[#008bb7] to-[#14b8a6]"></div>

<!-- MAIN CONTENT -->
<div class="bg-gray-50 min-h-screen">
    <main class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-12">

            <!-- ARTICLE BODY -->
            <article class="flex-1 min-w-0">

                <!-- Featured Image -->
                <div class="aspect-[21/9] max-w-4xl mx-auto rounded-[1.5rem] overflow-hidden shadow-2xl shadow-black/5 mb-10 bg-gray-100 px-0 sm:px-2">
                    <img
                        src="<?= htmlspecialchars($blog['img']) ?>"
                        alt="<?= htmlspecialchars($blog['title']) ?>"
                        class="w-full h-full object-cover rounded-[1.5rem]"
                        loading="lazy">
                </div>

                <div class="flex items-center gap-4 text-xs text-black/60 mb-6 font-bold">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?= htmlspecialchars($blog['date']) ?>
                    </span>

                    <span><?= htmlspecialchars($blog['author']) ?></span>
                </div>

                <!-- Content blocks -->
                <div id="articleContent">
                    <?php if (!is_array($blog['content'])): ?>
                        <div class="prose-content text-gray-700 leading-relaxed text-base sm:text-[17px]">
                            <?= $blog['content'] ?>
                        </div>
                    <?php else: ?>
                    <?php foreach ($blog['content'] as $block): ?>

                        <?php if ($block['type'] === 'intro'): ?>
                            <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-12 font-medium border-l-4 border-[#0eadae] pl-5 py-1">
                                <?= $block['text'] ?>
                            </p>

                        <?php elseif ($block['type'] === 'heading'): ?>
                            <section class="mb-8">
                                <h2 class="text-xl sm:text-2xl font-bold text-[#042A3F] mb-4 flex items-center gap-3">
                                    <span class="w-1 h-12 bg-gradient-to-b from-[#0eadae] to-[#064854] rounded-full flex-shrink-0"></span>
                                    <?= htmlspecialchars($block['text']) ?>
                                </h2>

                            <?php elseif ($block['type'] === 'para'): ?>
                                <p class="text-gray-600 leading-relaxed text-base sm:text-[17px] pl-4 mb-6">
                                    <?= $block['text'] ?>
                                </p>
                            </section>

                        <?php elseif ($block['type'] === 'list'): ?>
                            <ul class="space-y-3 pl-4 mb-6">
                                <?php foreach ($block['items'] as $item): ?>
                                    <li class="flex items-start gap-3 text-gray-600 text-base sm:text-[17px] leading-relaxed">
                                        <span class="w-2 h-2 rounded-full bg-[#0eadae] flex-shrink-0 mt-2"></span>
                                        <span><?= $item ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            </section>

                        <?php elseif ($block['type'] === 'callout'): ?>
                            <div class="bg-[#042A3F] rounded-2xl p-5 sm:p-8 my-10 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-[#0eadae]/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                                <div class="flex items-start gap-4 relative z-10">
                                    <div class="w-10 h-10 rounded-xl bg-[#0eadae]/20 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-[#0eadae]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <p class="text-white/90 text-sm sm:text-base leading-relaxed">
                                        <?= htmlspecialchars($block['text']) ?>
                                    </p>
                                </div>
                            </div>

                        <?php elseif ($block['type'] === 'conclusion'): ?>
                            <div class="bg-gradient-to-br from-[#e6f4f8] to-[#f0fafa] border border-[#b2dde8] rounded-2xl p-5 sm:p-7 mt-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-[#0eadae]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-[#0eadae] font-bold text-sm uppercase tracking-wider">Key Takeaway</span>
                                </div>
                                <p class="text-[#042A3F] leading-relaxed text-base sm:text-[17px] font-medium">
                                    <?= htmlspecialchars($block['text']) ?>
                                </p>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Author Card -->
                <div class="mt-12 p-5 sm:p-8 bg-[#f6f9fb] rounded-3xl border border-[#e2eaf0] flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden flex-shrink-0 shadow-lg">
                        <img src="<?= htmlspecialchars($blog['author_img']) ?>"
                            alt="<?= htmlspecialchars($blog['author']) ?>"
                            class="w-full h-full object-cover object-[center_5%]">
                    </div>
                    <div class="text-center sm:text-left">
                        <div class="text-xs font-bold uppercase tracking-[0.2em] text-[#0eadae] mb-1">Written by</div>
                        <div class="text-[#042A3F] font-bold text-lg sm:text-xl mb-1"><?= htmlspecialchars($blog['author']) ?></div>
                        <div class="text-[#1D6E9B] text-sm font-medium mb-2">MBBS, MD – General Physician &amp; Internal Medicine Specialist</div>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Dr. Manisha Gupta is a trusted General Physician specialising in diabetology, thyroid disorders, cardiology, and gastroenterology. She is committed to patient education and evidence-based, compassionate care.
                        </p>
                        <a href="about" class="inline-flex items-center gap-1.5 text-[#0eadae] text-xs font-bold mt-3 hover:gap-3 transition-all duration-200">
                            Learn More →
                        </a>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="contact"
                        class="relative overflow-hidden group inline-flex items-center gap-2 bg-[#0b3444] text-white font-semibold px-7 py-3.5 rounded-full transition-all duration-500 hover:shadow-[0_15px_35px_rgba(14,173,174,0.3)]">
                        <span class="relative z-10 flex items-center gap-2 group-hover:text-white transition-colors duration-300">
                            Book a Consultation
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                        <span class="absolute inset-0 bg-[#0eadae] translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-full"></span>
                    </a>
                    <a href="blogs" class="inline-flex items-center gap-2 text-[#042A3F] font-semibold text-sm hover:text-[#0eadae] transition-colors duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to All Blogs
                    </a>
                </div>

                <!-- Related Blogs -->
                <?php if (!empty($related)): ?>
                    <div class="mt-14">
                        <h3 class="text-[#042A3F] font-bold text-xl mb-6 flex items-center gap-3">
                            <span class="w-1 h-7 bg-gradient-to-b from-[#0eadae] to-[#064854] rounded-full flex-shrink-0"></span>
                            Related Articles
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            <?php foreach ($related as $rel): ?>
                                <a href="blog/<?= urlencode($rel['slug']) ?>"
                                    class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:border-[#0eadae] hover:shadow-lg transition-all duration-300 flex flex-col">
                                    <div class="relative h-40 overflow-hidden">
                                        <img src="<?= htmlspecialchars($rel['img']) ?>"
                                            alt="<?= htmlspecialchars($rel['title']) ?>"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                        <span class="absolute bottom-2 left-3 text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full <?= $rel['cat_color'] ?>">
                                            <?= htmlspecialchars($rel['cat']) ?>
                                        </span>
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <p class="text-[10px] text-gray-400 mb-1"><?= htmlspecialchars($rel['date']) ?></p>
                                        <h4 class="text-[#062D42] text-sm font-bold leading-snug line-clamp-2 group-hover:text-[#0eadae] transition-colors">
                                            <?= htmlspecialchars($rel['title']) ?>
                                        </h4>
                                        <p class="text-gray-500 text-xs mt-2 line-clamp-2 leading-relaxed flex-1">
                                            <?= htmlspecialchars($rel['excerpt']) ?>
                                        </p>
                                        <span class="inline-flex items-center gap-1 text-[#0eadae] text-xs font-bold mt-3">
                                            Read more →
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </article>

            <!-- SIDEBAR — sticky -->
            <aside class="w-full lg:w-[280px] xl:w-[300px] flex-shrink-0">
                <div class="lg:sticky lg:top-6 space-y-5">

                    <!-- All Categories — dynamic from data -->
                    <div class="sidebar-widget">
                        <h3 class="text-[#062D42] font-['Playfair_Display'] font-black text-lg mb-4">All Categories</h3>
                        <ul class="space-y-1">
                            <?php foreach ($categories as $i => $c):
                                $isActive = ($blog['cat'] === $c['slug']);
                            ?>
                                <li>
                                    <a href="blogs<?= $c['slug'] ? '?cat=' . urlencode($c['slug']) : '' ?>"
                                        class="flex items-center justify-between py-2 px-2 rounded-lg text-sm font-medium transition-all duration-200
                                              <?= $isActive ? 'text-[#0eadae] bg-[#0eadae]/8 font-bold' : 'text-[#062D42] hover:text-[#0eadae] hover:bg-[#0eadae]/5' ?>
                                              group">
                                        <span class="flex items-center gap-2">
                                            <?php if ($i > 0): ?>
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#0eadae] opacity-50 group-hover:opacity-100 transition-opacity"></span>
                                            <?php else: ?>
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                            <?php endif; ?>
                                            <?= htmlspecialchars($c['name']) ?>
                                        </span>
                                        <span class="bg-gray-100 text-gray-500 text-[11px] font-semibold px-2 py-0.5 rounded-full group-hover:bg-[#0eadae]/10 group-hover:text-[#0eadae] transition-colors">
                                            <?= $c['count'] ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Recent Blogs — dynamic from data -->
                    <div class="sidebar-widget">
                        <h3 class="text-[#062D42] font-['Playfair_Display'] font-black text-lg mb-4">Recent Blogs</h3>
                        <div class="space-y-3">
                            <?php foreach ($recent as $rp): ?>
                                <a href="blog/<?= urlencode($rp['slug']) ?>"
                                    class="flex items-start gap-3 p-2 -mx-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-14 h-12 rounded-xl overflow-hidden flex-shrink-0">
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

                    <!-- Book Consultation CTA -->
                    <div class="bg-[#062D42] rounded-2xl p-5 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-[#0eadae] opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="w-10 h-10 bg-[#0eadae]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-[#0eadae]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-white font-black text-base mb-2 leading-tight">Book a Consultation</h4>
                        <p class="text-white/60 text-xs leading-relaxed mb-4">Have health concerns? Get personalised advice from Dr. Manisha Gupta.</p>
                        <a href="contact"
                            class="inline-flex items-center gap-2 bg-[#0eadae] hover:bg-[#0a9596] text-white text-xs font-bold px-5 py-2.5 rounded-full transition-all duration-200">
                            Connect with us
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Back to All Blogs -->
                    <a href="blogs" class="flex items-center justify-center gap-2 w-full border-2 border-[#062D42] text-[#062D42] font-bold text-sm py-3 rounded-xl hover:bg-[#062D42] hover:text-white transition-all duration-200">
                        ← Back to All Blogs
                    </a>

                </div>
            </aside>

        </div>
    </main>
</div>

<?php include 'components/footer.php'; ?>

<script>
    // Reading progress bar
    window.addEventListener('scroll', () => {
        const art = document.getElementById('articleContent');
        if (!art) return;
        const top = art.getBoundingClientRect().top + window.scrollY;
        const pct = Math.min(
            Math.max((window.scrollY - top + window.innerHeight * 0.3) / art.offsetHeight * 100, 0),
            100
        );
        document.getElementById('readingProgress').style.width = pct + '%';
    });

    // Anchor IDs on headings for TOC / deep linking
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#articleContent h2').forEach((h, i) => {
            h.id = 'section-' + (i + 1);
        });
    });
</script>
