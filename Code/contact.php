<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "config_mail.php";
$sent = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $msg = trim($_POST['message'] ?? "");
    $consent = isset($_POST['consent']);

    if (!$consent) {
        $error = "Bitte der Datenverarbeitung zustimmen.";
    } elseif ($msg === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Bitte gültige E-Mail und Nachricht angeben.";
    } else {
        $ok = false;
        if (file_exists(__DIR__ . "/vendor/autoload.php")) {
            require_once __DIR__ . "/vendor/autoload.php";
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = SMTP_SECURE;
                $mail->Port = SMTP_PORT;

                $mail->setFrom(SMTP_USER, "Jugendkreis-Website");
                $mail->addReplyTo($email, $name ?: "Website-Besucher");
                $mail->addAddress(CONTACT_TO, "Jugendkreis");
                $mail->Subject = "Kontaktformular Jugendkreis";
                $mail->Body = "Name: " . ($name ?: "—") . "\nE-Mail: $email\n\nNachricht:\n$msg";
                $mail->send();
                $ok = true;
            } catch (Throwable $e) {
                $error = "Fehler beim Senden über SMTP: " . $e->getMessage();
            }
        }

        if (!$ok) {
            $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
            $ok = @mail(CONTACT_TO, "Kontaktformular Jugendkreis", $msg . "\n\nVon: " . ($name ?: "—") . " <$email>", $headers);
        }

        $sent = $ok;
        if (!$ok && !$error) $error = "Mail konnte nicht gesendet werden.";
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt – Jugendkreis</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Kontakt</h1>
        <p>Fragen, Ideen oder Anliegen? Schreib uns.</p>
        <a href="index.php" class="admin-link">← Zurück</a>
    </header>

    <main>
        <?php if ($sent === true): ?>
            <p style="text-align:center;color:var(--accent-light);">✅ Nachricht erfolgreich versendet.</p>
        <?php elseif ($sent === false): ?>
            <p style="text-align:center;color:#e56b6f;">❌ <?= htmlspecialchars($error ?? "Fehler beim Senden.") ?></p>
        <?php elseif ($error): ?>
            <p style="text-align:center;color:#e56b6f;">❌ <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <section class="new-event" style="max-width:700px;margin:1.5rem auto;">
            <h2>Schreib uns</h2>
            <form method="post">
                <input type="text" name="name" placeholder="Dein Name (optional)">
                <input type="email" name="email" placeholder="Deine E-Mail" required>
                <textarea name="message" placeholder="Deine Nachricht ..." required></textarea>
                <label style="color:var(--muted);font-size:.95rem;">
                    <input type="checkbox" name="consent" required>
                    Ich stimme der Verarbeitung meiner Angaben zum Zweck der Kontaktaufnahme zu.
                </label>
                <button type="submit">Senden</button>
            </form>
            <p class="meta" style="margin-top:.8rem;">
                Hinweis: Wir speichern deine Angaben nur zur Bearbeitung deiner Anfrage.
                Details siehe <a href="impressum.html">Impressum/Datenschutz</a>.
            </p>
        </section>
    </main>

    <footer>
        <p>© Jugendkreis-Team · <a href="impressum.html">Impressum</a></p>
    </footer>
</body>

</html>