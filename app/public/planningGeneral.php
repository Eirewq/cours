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

$nombreServicesParJour = $planning->getNombreServiceGeneral($premiereDateSemaine, $derniereDateSemaine);
$intervenant = $planning->getIntervenant($premiereDateSemaine, $derniereDateSemaine);

echo $page->render('planningGeneral.html.twig', [
    'user' => $user, 
    'semaineActuel' => $semaineActuel,
    'datesSemaine' => $datesSemaine,
    'intervenants' => $intervenant,
    'nombreServicesParJour' => $nombreServicesParJour
]);
?>
