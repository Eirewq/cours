<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classFormAjout;

$page = new Page();
$session = new Session();
$formAjout = new classFormAjout();

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if (isset($_POST["table"])) {
    $table = $_POST["table"];
}

if (isset($_POST["nomStatus"])) {
    $nomStatus = $_POST["nomStatus"];
    $formAjout->createStatus($nomStatus);
    header("Location: admin.php");
}

if (isset($_POST["nomCategorie"])) {
    $nomCategorie = $_POST["nomCategorie"];
    $formAjout->createCategorie($nomCategorie);
    header("Location: admin.php");
}

if (isset($_POST["nomUrgence"])) {
    $nomUrgence = $_POST["nomUrgence"];
    $formAjout->createUrgence($nomUrgence);
    header("Location: admin.php");
}

$user = $session->get('user');

echo $page->render('formAjout.html.twig', ['user' => $user, 'table' => $table]);
?>
