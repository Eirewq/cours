<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$errors = []; 
$email = urldecode($_GET['email'] ?? ''); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    
    if (strlen($nom) < 2 || strlen($prenom) < 2) {
        $errors['nom'] = "Nom ou Prénom invalide"; 
    } else {
        try {
            $page->updateUserInfo($nom, $prenom, $email); 
            header("Location: index.php");
            exit();
        } catch (\Exception $e) {
            $errors['database'] = $e->getMessage();
        }   
    } 
}

echo $page->render('signIn2.html.twig', ['errors' => $errors]);

