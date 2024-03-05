<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$errors = []; // Initialiser le tableau des erreurs

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    
    // Vérifier si les mots de passe correspondent
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors['email'] = "Email invalide";
    } elseif ($password !== $confirmPassword){
        $errors['confirmPassword'] = "Les mots de passe ne correspondent pas.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $password)){
        $errors['password'] = "Mot de passe incorrect";
    } else {
        if (!$page->checkEmailExists($email)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $page->insertUser($email, $hashedPassword);
                // Redirection après une inscription réussie
                header("Location: signIn2.php?email=" . urlencode($email));
                exit();
            } catch (\Exception $e) {
                $errors['database'] = $e->getMessage();
            }
        } else {
            $errors['email'] = "L'adresse email est déjà utilisée.";
        }        
    } 
}

// Passer les erreurs au modèle Twig
echo $page->render('signIn.html.twig', ['errors' => $errors]);
