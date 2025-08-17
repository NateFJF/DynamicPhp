<?php
require_once __DIR__ . '/../includes/bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$flash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $type    = trim($_POST['type'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) &&
        in_array($type, ['general feedback','complaint'], true) &&
        $message) {

        $mail = new PHPMailer(true);
        try {
            // Load secret config (throws if missing)
            $configPath = __DIR__ . '/../includes/mail_config.php';
            if (!file_exists($configPath)) {
                throw new Exception('Missing mail_config.php. Copy includes/mail_config.php.dist and fill in your credentials.');
            }
            $cfg = require $configPath;

            // SMTP transport
            $mail->isSMTP();
            $mail->Host       = $cfg['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $cfg['user'];
            $mail->Password   = $cfg['pass'];
            $mail->SMTPSecure = $cfg['secure'];
            $mail->Port       = (int)$cfg['port'];

            // Message meta
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(false);

            // From/To
            $mail->setFrom($cfg['from'], 'Moplin Website');
            $mail->addAddress($cfg['to']);
            $mail->addReplyTo($email, $name);

            // Subject/body per brief
            $mail->Subject = $type; // exactly "general feedback" or "complaint"
            $mail->Body    = "User email: {$email}\nComment: {$message}";

            $mail->send();
            $flash = 'Message sent successfully!';
        } catch (Exception $e) {
            error_log('Mailer Error: ' . ($mail->ErrorInfo ?? $e->getMessage()));
            $flash = 'Could not send message. Please check mail settings.';
        }
    } else {
        $flash = 'Please fill all fields correctly.';
    }
}

echo $twig->render('contact.html.twig', [
    'title' => 'Contact Us',
    'flash' => $flash,
]);
