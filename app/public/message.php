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

// cas venant de l'intervenant
if (isset($_POST["id_service"]) OR isset($_SESSION["id_service"]) ) {
    $id_service = $_POST["id_service"] ?? $_SESSION["id_service"];
    $service = $classMessage->getService($id_service);
    $id_client = $service[0]['id_client'];
    $client = $classMessage->getClient($id_client);
    if(isset($_POST["newStatut"])){
        $id_statut = $_POST["newStatut"] ?? '';
        $classMessage->updateSatutService($id_service, $id_statut);
        header("Location: planningIntervenant.php");
    }
}

$user = $session->get('user');

// cas venant du Client 
if($user['role'] == 'Client'){
    $id_interenant = $service[0]['id_intervenant'];
    $intervenant = $classMessage->getClient($id_interenant);
} else {
    $id_interenant = $user['id_user'];
    $intervenant = $classMessage->getClient($id_interenant);
}

if (isset($_POST["message"])) {
    $contenu = $_POST["message"];
    $_SESSION['id_service'] = $id_service; 
    $classMessage->insertMessage($id_service, $user['id_user'], $contenu);
    header("Location: message.php");
}

$statut = $classMessage->getStatut();
$messages = $classMessage->getMessageService($id_service, $id_interenant, $id_client);

echo $page->render('message.html.twig', ['user' => $user, 'service' => $service, 'client' => $client, 'statuts' => $statut, 'messages' => $messages, "intervenant" => $intervenant]);
?>
