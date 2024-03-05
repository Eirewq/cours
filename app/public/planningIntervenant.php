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

$user = $session->get('user');
$semaineActuel = isset($_GET['semaine']) ? $_GET['semaine'] : date('W');
$anneeActuelle = date('Y');
$datesSemaine = $planning->getDatesSemaine($semaineActuel, $anneeActuelle);
$premiereDateSemaine = $datesSemaine[0]['date']; 
$derniereDateSemaine = end($datesSemaine)['date']; 
$servicesIntervenant = [];

foreach ($datesSemaine as $jour) {
    $services = $planning->getService($jour['date'], $user["id_user"]);
    $servicesIntervenant[$jour['date']] = $services;
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

echo $page->render('planningIntervenant.html.twig', [  'user' => $user, 
                                                       'semaineActuel' => $semaineActuel,
                                                       'datesSemaine' => $datesSemaine,
                                                       'servicesIntervenant' => $servicesIntervenant,
                                                       'clients' => $clients,
                                                       'urgences' => $urgences,
                                                    ]);
?>
