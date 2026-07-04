<?php
// Conexiune PDO către MySQL (tabel `programari`). Prepared statements exclusiv (R21).

function db(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $config = require __DIR__ . '/../config/config.php';
    $db = $config['db'];

    $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'] . ';charset=utf8mb4';

    try {
        $pdo = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        error_log('DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        die('Eroare server. Te rugăm încearcă din nou mai târziu.');
    }

    return $pdo;
}
