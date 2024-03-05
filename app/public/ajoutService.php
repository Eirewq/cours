<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classAjoutService;

$page = new Page();
$session = new Session();
$ajoutService = new classAjoutService();
$errors = []; 

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_intervenant = $_POST["id_intervenant"] ?? '';
    $email = $_POST["email"] ?? '';
    $id_standardiste = $_POST["id_standardiste"] ?? '';
    $id_categorie = $_POST["id_categorie"] ?? '';
    $id_urgence = $_POST["id_urgence"] ?? '';
    $dateIntervention = $_POST["date"] ?? '';
    $nomService = $_POST["nomService"] ?? '';
    $heureFin = $_POST["heureFin"] ?? '';
    $heureDebut = $_POST["heureDebut"] ?? '';

    if ($page->checkEmailExists($email)){
        $id_client = $ajoutService->getIdWithEmail($email);
        $ajoutService->insertService($id_intervenant, $id_client[0]['id_user'], $id_standardiste, $id_categorie, $id_urgence, $dateIntervention, $nomService, $heureFin, $heureDebut);
        header("Location: planningGeneral.php");
    } else {
        $errors['email'] = "Email Inconnue"; 

    }
}

$user = $session->get('user');
$categorie = $ajoutService->getCategorie();
$intervenant = $ajoutService->getIntervenant();
$urgence = $ajoutService->getUrgence();

echo $page->render('ajoutService.html.twig', ['user' => $user, 'categories' => $categorie, 'intervenants' => $intervenant, 'urgences' => $urgence, 'errors' => $errors]);
?>
