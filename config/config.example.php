<?php
// Model config — copiază structura, FĂRĂ valori reale.
// Valorile reale se setează ca variabile de mediu pe server (vezi prompts/_ENV.md §6),
// citite de config.php prin getenv(). Acest fișier e doar documentație a cheilor așteptate.
// Pentru DEV LOCAL fără export manual de env vars: vezi config.local.php.example (FIX-01).

return [
    'db' => [
        'host' => '', // DB_HOST
        'port' => '', // DB_PORT (opțional, implicit 3306)
        'name' => '', // DB_NAME
        'user' => '', // DB_USER
        'pass' => '', // DB_PASS
    ],
    'smtp' => [
        'host' => '', // SMTP_HOST
        'port' => '', // SMTP_PORT
        'user' => '', // SMTP_USER
        'pass' => '', // SMTP_PASS
    ],
    'salon_email' => '', // SALON_EMAIL
];
