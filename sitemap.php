<?php
require_once __DIR__ . '/data/blogs.php';

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$basePath = preg_replace('#/(sitemap|robots)\.(php|xml|txt)$#i', '', $scriptDir);
$siteUrl = rtrim($scheme . '://' . $host . ($basePath ?: ''), '/');

$today = date('Y-m-d');
$urls = [
    ['loc' => $siteUrl . '/', 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => $siteUrl . '/about', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => $siteUrl . '/blogs', 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.8'],
    ['loc' => $siteUrl . '/contact', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.7'],
];

foreach (getAllBlogs() as $blog) {
    $lastmod = $today;
    if (!empty($blog['timestamp']) && preg_match('/^\d{8}$/', (string) $blog['timestamp'])) {
        $lastmod = substr((string) $blog['timestamp'], 0, 4) . '-' . substr((string) $blog['timestamp'], 4, 2) . '-' . substr((string) $blog['timestamp'], 6, 2);
    }

    $urls[] = [
        'loc' => $siteUrl . '/blog/' . rawurlencode($blog['slug']),
        'lastmod' => $lastmod,
        'changefreq' => 'monthly',
        'priority' => '0.7',
    ];
}

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
  <url>
    <loc><?= htmlspecialchars($url['loc'], ENT_XML1, 'UTF-8') ?></loc>
    <lastmod><?= htmlspecialchars($url['lastmod'], ENT_XML1, 'UTF-8') ?></lastmod>
    <changefreq><?= htmlspecialchars($url['changefreq'], ENT_XML1, 'UTF-8') ?></changefreq>
    <priority><?= htmlspecialchars($url['priority'], ENT_XML1, 'UTF-8') ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
