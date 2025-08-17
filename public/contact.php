<?php
require_once __DIR__ . '/../includes/bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$flash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // -------------------- Basic validation --------------------------
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && in_array($type, ['general feedback','complaint'], true) && $message) {
        $mail = new PHPMailer(true);
        try {
            // Configuring transport
            $mail->isMail();

            $mail->setFrom('no-reply@tshirtshop.com', 'Moplin Website');
            $mail->addAddress('youremail@emailserver.com');
            $mail->Subject = $type;
            $mail->Body = "User email: {$email}\nComment: {$message}";

            $mail->send();
            $flash = 'Message sent successfully!';
        } catch (Exception $e) {
            $flash = 'Could not send message. Please try again later.';
        }
    } else {
        $flash = 'Please fill all fields correctly.';
    }
}

echo $twig->render('contact.html.twig', [
    'title' => 'Contact Us',
    'flash' => $flash,
]);