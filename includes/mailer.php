<?php
// Wrapper PHPMailer (SMTP autentificat) — nu se folosește mail() brut (Architecture §1.4).

require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * @return bool succes trimitere
 */
function trimite_email(string $catre, string $subiect, string $corp): bool
{
    $config = require __DIR__ . '/../config/config.php';
    $smtp = $config['smtp'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['user'];
        $mail->Password = $smtp['pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) $smtp['port'];
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        $mail->setFrom($smtp['user'], 'Lumea Unghiilor');
        $mail->addAddress($catre);

        $mail->Subject = $subiect;
        $mail->Body = $corp;
        $mail->isHTML(false);

        $mail->send();
        return true;
    } catch (PHPMailerException $e) {
        error_log('Trimitere email eșuată: ' . $mail->ErrorInfo);
        return false;
    }
}
