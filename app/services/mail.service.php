<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php'; //adapter si besoin

// Charger les variables d'environnement
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function send_user_credentials(string $email, string $prenom, string $password): bool {
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // ou ton serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Infos de l'email
        $mail->setFrom('Tapha.ednayas313@gmail.com', 'Admin GES Apprenant');
        $mail->addAddress($email, $prenom);

        $mail->isHTML(true);
        $mail->Subject = 'Vos identifiants pour GES Apprenant';
        $mail->Body = "
            <h3>Bonjour $prenom,</h3>
            <p>Vous avez été inscrit(e) sur la plateforme GES Apprenant.</p>
            <p><strong>Email :</strong> $email<br>
            <strong>Mot de passe :</strong> $password</p>
            <p>Veuillez vous connecter et changer votre mot de passe dès la première connexion.</p>
        ";
        // <p><a href='http://ton-domaine/login.php'>Se connecter</a></p>

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erreur mail: " . $mail->ErrorInfo);
        return false;
    }
}
