<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classModifBase;

$page = new Page();
$session = new Session();
$modifBase = new classModifBase();
$searchTerm = '';
//$rows = $modifBase->selectAll($searchTerm);

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
    //$rows = $modifBase->selectAll($searchTerm); // Passer le terme de recherche à la méthode selectAll
}


$urlActuelle = basename($_SERVER['PHP_SELF']);

//$user = $session->get('user');

echo $page->render('modifBase.html.twig', ['urlActuelle' => $urlActuelle]);
?>
