<?php
require_once __DIR__ . '/functions.php';

$activ = $activ ?? '';

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
<title>Lumea Unghiilor — Salon de unghii</title>
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
