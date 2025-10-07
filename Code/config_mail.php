<?php
// PHPMailer laden (Composer)
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    $autoload = __DIR__ . '/../vendor/autoload.php';
}
if (file_exists($autoload)) {
    require_once $autoload;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Empfänger-Adresse
define('CONTACT_TO', 'niklas.hardwig@jugendkreis-aule.com');

// SMTP-Zugangsdaten (All-Inkl)
define('SMTP_HOST', 'smtp.kasserver.com');
define('SMTP_USER', 'niklas.hardwig@jugendkreis-aule.com');
define('SMTP_PASS', '7YDw79Hm0C2SpP1HBywA'); // dein Mailpasswort
define('SMTP_PORT', 587);
define('SMTP_SECURE', PHPMailer::ENCRYPTION_STARTTLS);
