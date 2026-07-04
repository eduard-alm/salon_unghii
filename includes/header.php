<?php
require_once __DIR__ . '/functions.php';

$activ = $activ ?? '';
$title = $title ?? 'Lumea Unghiilor — Salon de unghii';
$description = $description ?? '';

$schemeHttp = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$hostHttp = $_SERVER['HTTP_HOST'] ?? 'localhost';
$pathHttp = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$canonical = $schemeHttp . '://' . $hostHttp . $pathHttp;

$navLinks = [
    'acasa'    => ['href' => '/', 'label' => 'Acasă'],
    'servicii' => ['href' => '/servicii', 'label' => 'Servicii'],
    'galerie'  => ['href' => '/galerie', 'label' => 'Galerie'],
    'despre'   => ['href' => '/despre', 'label' => 'Despre'],
    'contact'  => ['href' => '/contact', 'label' => 'Contact'],
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<?php if ($description !== ''): ?>
<meta name="description" content="<?= e($description) ?>">
<?php endif; ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Lumea Unghiilor">
<meta property="og:locale" content="ro_RO">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<?php if ($description !== ''): ?>
<meta property="og:description" content="<?= e($description) ?>">
<?php endif; ?>
<?php if ($activ === 'acasa'): ?>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NailSalon',
    'name' => 'Lumea Unghiilor',
    'url' => $canonical,
    'image' => $schemeHttp . '://' . $hostHttp . '/assets/images/hero-manichiura.svg',
    'telephone' => '⟨07xx xxx xxx⟩',
    'priceRange' => '$$',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => '⟨Str. Exemplu nr. 10⟩',
        'addressLocality' => '⟨Cluj-Napoca⟩',
        'addressCountry' => 'RO',
    ],
    'openingHoursSpecification' => [
        [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '09:00',
            'closes' => '19:00',
        ],
        [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Saturday'],
            'opens' => '09:00',
            'closes' => '15:00',
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<!-- TODO: adresă și telefon reale înainte de lansare (vezi _ENV.md §8) -->
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/variables.css">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <nav class="navbar container">
    <a href="/" class="logo">Lumea Unghiilor</a>
    <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="nav-links" aria-label="Deschide meniul">
      &#9776;
    </button>
    <div class="nav-links" id="nav-links">
      <?php foreach ($navLinks as $slug => $link): ?>
        <a href="<?= e($link['href']) ?>"<?= $activ === $slug ? ' class="active"' : '' ?>><?= e($link['label']) ?></a>
      <?php endforeach; ?>
      <a href="/contact" class="btn" style="padding:10px 22px">Programează-te</a>
    </div>
  </nav>
</header>
<main>
