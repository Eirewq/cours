<?php
require_once '../vendor/autoload.php';

use App\Session;

$session = new Session();

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$session->destroy();
header('Location: index.php');

?>
