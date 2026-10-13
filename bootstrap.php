<?php
// Set timezone to Asia/Kolkata (Indian Standard Time)
date_default_timezone_set('Asia/Kolkata');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/captcha_helper.php';

// Load .env file variables
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $name = trim($parts[0]);
            $value = trim($parts[1]);
            $value = trim($value, '"\''); // Remove quotes
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

function agdm_include_part(string $fileName): void
{
  global $pageTitle, $pageDescription, $pageKeywords, $pageSchema, $canonicalUrl, $noIndex, $ogTitle, $ogDescription, $ogUrl, $ogType, $ogImage, $twitterCard, $twitterTitle, $twitterDescription, $twitterImage;

  $lowerPath = __DIR__ . '/includes/' . $fileName;
  $upperPath = __DIR__ . '/Includes/' . $fileName;

  if (file_exists($lowerPath)) {
    include $lowerPath;
    return;
  }

  if (file_exists($upperPath)) {
    include $upperPath;
    return;
  }

  http_response_code(500);
  echo "Template file missing: " . htmlspecialchars($fileName);
}
