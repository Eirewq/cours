<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classPlanning;

$page = new Page();
$session = new Session();
$planning = new classPlanning();

if (!$session->isConnected()) {
    header('Location: index.php');
    exit();
}

$id_intervenant = isset($_POST["id_intervenant"]) ? $_POST["id_intervenant"] : null;
$joursAvecService = isset($_POST["joursAvecService"]) ? $_POST["joursAvecService"] : null;
if (isset($_POST['joursSemaine'])) {
    $joursSemaine = $_POST['joursSemaine'];
}

if (!$id_intervenant) {
    echo "pas d'intervenant";
}

$user = $session->get('user');
$servicesIntervenant = [];
$infoIntervenant = $planning->getInfo($id_intervenant);

foreach ($joursSemaine as $jour) {
    $services = $planning->getService($jour, $id_intervenant);
    $servicesIntervenant[$jour] = $services;
}

$clients = [];

foreach ($servicesIntervenant as $jour => $services) {
    foreach ($services as $service) {
        if (isset($service['id_client'])) {
            $clientId = $service['id_client'];
            if (!isset($clients[$clientId])) {
                $clientInfo = $planning->getInfo($clientId);
                $clients[$clientId] = $clientInfo;
            }
        }
    }
}

$urgences = $planning->getUrgence();

echo $page->render('planningPerso.html.twig', [  'user' => $user, 
                                                 'servicesIntervenant' => $servicesIntervenant,
                                                 'intervenant' => $infoIntervenant,
                                                 'clients' => $clients,
                                                 'urgences' => $urgences,
                                              ]);
?>
