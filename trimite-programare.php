<?php
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Metodă nepermisă.');
}

if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Token CSRF invalid.');
}

if (!empty($_POST['website'] ?? '')) {
    // Honeypot completat -> e bot; ignoră silențios, pretinde succes (Architecture §3.2).
    header('Location: /contact?status=succes');
    exit;
}

$nume = trim($_POST['nume'] ?? '');
$telefon = normalizeaza_telefon(trim($_POST['telefon'] ?? ''));
$serviciu = trim($_POST['serviciu'] ?? '');
$data = trim($_POST['data'] ?? '');
$ora = trim($_POST['ora'] ?? '');
$mesaj = trim($_POST['mesaj'] ?? '');
$gdpr = isset($_POST['gdpr']);

$valid = valid_nume($nume)
    && valid_telefon($telefon)
    && valid_serviciu($serviciu)
    && valid_data($data)
    && valid_ora($ora, $data)
    && valid_mesaj($mesaj)
    && $gdpr;

if (!$valid) {
    $_SESSION['form_prev'] = compact('nume', 'telefon', 'serviciu', 'data', 'ora', 'mesaj');
    header('Location: /contact?status=eroare');
    exit;
}

require_once __DIR__ . '/includes/db.php';

try {
    $stmt = db()->prepare(
        'INSERT INTO programari (nume, telefon, serviciu, data_dorita, ora_dorita, mesaj, ip)
         VALUES (:nume, :telefon, :serviciu, :data_dorita, :ora_dorita, :mesaj, :ip)'
    );
    $stmt->execute([
        'nume' => $nume,
        'telefon' => $telefon,
        'serviciu' => $serviciu,
        'data_dorita' => $data,
        'ora_dorita' => $ora,
        'mesaj' => $mesaj !== '' ? $mesaj : null,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
} catch (PDOException $e) {
    error_log('Salvare programare eșuată: ' . $e->getMessage());
    header('Location: /contact?status=eroare');
    exit;
}

unset($_SESSION['form_prev']);

require_once __DIR__ . '/includes/mailer.php';
$config = require __DIR__ . '/config/config.php';

$corpNotificare = "Nume: {$nume}\nTelefon: {$telefon}\nServiciu: {$serviciu}\nData/ora: {$data} {$ora}\nMesaj: {$mesaj}";
$subiectNotificare = "Programare nouă — {$nume} / {$serviciu} / {$data} {$ora}";

// Dacă emailul eșuează, programarea rămâne salvată; eroarea se loghează, clienta vede tot succes (Architecture §7).
trimite_email($config['salon_email'], $subiectNotificare, $corpNotificare);

header('Location: /contact?status=succes');
exit;
