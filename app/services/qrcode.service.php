<?php
require_once 'vendor/autoload.php';
require_once 'auth_check.php';
require_once 'ApprenantModel.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Récupération de l'apprenant
$apprenant = $apprenantModel->getById($_SESSION['apprenant_id']);

// Données à encoder
$data = json_encode([
    'matricule' => $apprenant['matricule'],
    'email' => $apprenant['email'],
    'prenom' => $apprenant['prenom'],
    'nom' => $apprenant['nom']
]);

// Générer le QR code
$qrCode = QrCode::create($data)->setSize(200)->setMargin(10);
$writer = new PngWriter();
$result = $writer->write($qrCode);

// Afficher le QR code dans le navigateur
header('Content-Type: ' . $result->getMimeType());
echo $result->getString();
exit;
