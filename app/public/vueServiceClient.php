<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classClient;

$page = new Page();
$session = new Session();
$classClient = new classClient();

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer les informations de l'utilisateur depuis la session
$user = $session->get('user');
$id_user = $user['id_user'];
$services = $classClient->getService($id_user);
$intervenants = $classClient->getIntervenant();
$urgences = $classClient->getUrgence();

echo $page->render('vueServiceClient.html.twig', ['user' => $user, 'services' => $services, 'intervenants' => $intervenants, 'urgences' => $urgences]);
?>
