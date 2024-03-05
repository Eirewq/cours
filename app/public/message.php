<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classMessage;

$page = new Page();
$session = new Session();
$classMessage = new classMessage();

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["id_service"])) {
    $id_service = $_POST["id_service"] ?? '';
    $service = $classMessage->getService($id_service);
    $id_client = $service[0]['id_client'];
    $client = $classMessage->getClient($id_client);
    if(isset($_POST["newStatut"])){
        $id_statut = $_POST["newStatut"] ?? '';
        $classMessage->updateSatutService($id_service, $id_statut);
        header("Location: planningIntervenant.php");
    }
}

$statut = $classMessage->getStatut();

echo $page->render('message.html.twig', ['service' => $service, 'client' => $client, 'statuts' => $statut]);
?>
