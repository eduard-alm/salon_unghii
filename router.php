<?php
/**
 * Router DOAR pentru dev local: `php -S localhost:8000 router.php`.
 * Reproduce local comportamentul .htaccess (URL curat -> fișier .php).
 * .htaccess rămâne sursa de adevăr pentru producție (Apache); acest
 * fișier nu e folosit acolo.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Fișier static existent (CSS, JS, imagini) -> îl servește php -S direct.
if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

$routes = [
    '/'         => 'index.php',
    '/servicii' => 'servicii.php',
    '/galerie'  => 'galerie.php',
    '/despre'   => 'despre.php',
    '/contact'  => 'contact.php',
    '/trimite-programare' => 'trimite-programare.php',
];

$slug = rtrim($uri, '/');
if ($slug === '') {
    $slug = '/';
}

$file = $routes[$slug] ?? null;

if ($file !== null && is_file(__DIR__ . '/' . $file)) {
    require __DIR__ . '/' . $file;
    return true;
}

http_response_code(404);
if (is_file(__DIR__ . '/404.php')) {
    require __DIR__ . '/404.php';
} else {
    echo '404 — Pagina nu a fost găsită.';
}
return true;
