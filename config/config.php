<?php
// Config aplicație — citește STRICT variabile de mediu (fără nicio valoare
// reală aici, R20). Comis în Git: conține doar logică getenv(), nu secrete.
// Valorile reale se setează pe server (local: config.local.php gitignored;
// producție: env vars din Coolify — vezi prompts/_ENV.md §6).
// Eșuează zgomotos, cu numele variabilei, dacă lipsește ceva (R22).

// Fallback DOAR pentru dev local: dacă DB_HOST lipsește din mediu, încarcă
// config.local.php (gitignored, vezi config.local.php.example) care face
// putenv() pentru fiecare variabilă. Pe producție acest fișier nu există,
// deci getenv() rămâne singura sursă (R22 neatins).
if (getenv('DB_HOST') === false && is_file(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
}

if (!function_exists('config_env')) {
    function config_env(string $name): string
    {
        $value = getenv($name);
        if ($value === false || $value === '') {
            http_response_code(500);
            die('Eroare configurare: variabila de mediu "' . $name . '" lipsește sau e goală.');
        }
        return $value;
    }
}

return [
    'db' => [
        'host' => config_env('DB_HOST'),
        'port' => getenv('DB_PORT') ?: '3306', // opțional — implicit portul standard MySQL
        'name' => config_env('DB_NAME'),
        'user' => config_env('DB_USER'),
        'pass' => config_env('DB_PASS'),
    ],
    'smtp' => [
        'host' => config_env('SMTP_HOST'),
        'port' => config_env('SMTP_PORT'),
        'user' => config_env('SMTP_USER'),
        'pass' => config_env('SMTP_PASS'),
    ],
    'salon_email' => config_env('SALON_EMAIL'),
];
