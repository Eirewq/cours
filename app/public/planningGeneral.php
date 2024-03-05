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

$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Récupérer les données selon la recherche ou non
if (!empty($search)) {
    $nombreServicesParJour = $planning->getNombreServiceGeneral($premiereDateSemaine, $derniereDateSemaine, $search);
    $intervenant = $planning->getIntervenant($premiereDateSemaine, $derniereDateSemaine, $search);
} else {
    $nombreServicesParJour = $planning->getNombreServiceGeneral($premiereDateSemaine, $derniereDateSemaine);
    $intervenant = $planning->getIntervenant($premiereDateSemaine, $derniereDateSemaine);
}

echo $page->render('planningGeneral.html.twig', [
    'user' => $user, 
    'semaineActuel' => $semaineActuel,
    'datesSemaine' => $datesSemaine,
    'intervenants' => $intervenant,
    'nombreServicesParJour' => $nombreServicesParJour
]);
?>
