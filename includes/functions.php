<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function csp_nonce(): string
{
    static $nonce = null;
    if ($nonce === null) {
        $nonce = base64_encode(random_bytes(16));
    }
    return $nonce;
}

function trimite_headere_securitate(): void
{
    if (headers_sent()) {
        return;
    }

    $nonce = csp_nonce();

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

    $https = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
        || ($_SERVER['HTTPS'] ?? '') === 'on';
    if ($https) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    header(
        "Content-Security-Policy: default-src 'self'; "
        . "script-src 'self' 'nonce-{$nonce}'; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' https://fonts.gstatic.com; "
        . "img-src 'self' data:; "
        . "base-uri 'self'; "
        . "form-action 'self'; "
        . "frame-ancestors 'self'; "
        . "object-src 'none'"
    );
}

trimite_headere_securitate();

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

const SERVICII_VALIDE = [
    'Manichiură clasică',
    'Manichiură semipermanentă',
    'Construcție',
    'Pedichiură',
    'Nail art',
    'Altceva',
];

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_valid(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function utf8_len(string $s): int
{
    return preg_match_all('/./us', $s);
}

function valid_nume(string $nume): bool
{
    $len = utf8_len($nume);
    if ($len < 2 || $len > 100) {
        return false;
    }
    return (bool) preg_match('/^[\p{L}\s\-]+$/u', $nume);
}

function normalizeaza_telefon(string $telefon): string
{
    return preg_replace('/[\s\-]+/', '', $telefon);
}

function valid_telefon(string $telefon): bool
{
    return (bool) preg_match('/^0[0-9]{9}$/', $telefon);
}

function valid_serviciu(string $serviciu): bool
{
    return in_array($serviciu, SERVICII_VALIDE, true);
}

function valid_data(string $data): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $data);
    if (!$d || $d->format('Y-m-d') !== $data) {
        return false;
    }
    $azi = new DateTime('today');
    return $d >= $azi;
}

function valid_ora(string $ora, string $data): bool
{
    if (!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $ora)) {
        return false;
    }

    $d = DateTime::createFromFormat('Y-m-d', $data);
    if (!$d) {
        return false;
    }

    $ziuaSaptamana = (int) $d->format('N'); // 1=Luni ... 7=Duminică
    if ($ziuaSaptamana === 7) {
        return false; // Duminică închis
    }

    $limita = $ziuaSaptamana === 6 ? '15:00' : '19:00'; // Sâmbătă vs Luni-Vineri
    return $ora >= '09:00' && $ora <= $limita;
}

function valid_mesaj(string $mesaj): bool
{
    return utf8_len($mesaj) <= 1000;
}
