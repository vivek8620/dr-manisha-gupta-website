<?php
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$basePath = preg_replace('#/(sitemap|robots)\.(php|xml|txt)$#i', '', $scriptDir);
$siteUrl = rtrim($scheme . '://' . $host . ($basePath ?: ''), '/');
$robotsBase = '/' . trim($basePath ?: '', '/');
$robotsBase = $robotsBase === '/' ? '' : $robotsBase;

header('Content-Type: text/plain; charset=UTF-8');
echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: {$robotsBase}/data/\n";
echo "Disallow: {$robotsBase}/components/\n";
echo "Sitemap: {$siteUrl}/sitemap.xml\n";
