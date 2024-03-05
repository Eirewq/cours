<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;

$page = new Page();
$session = new Session();
$errors = []; // Initialise le tableau d'erreurs

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer les informations de l'utilisateur depuis la session
$user = $session->get('user');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $role = $_POST["role"] ?? '';
    $id_user = $_POST["id_user"] ?? '';

    // Validation des données
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email invalide";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $password)) {
        $errors['password'] = "Mot de passe invalide";
    } elseif (strlen($nom) < 2) {
        $errors['nom'] = "Nom invalide";
    } elseif (strlen($prenom) < 2) {
        $errors['prenom'] = "Prénom invalide";
    } else {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            // Met à jour les informations de l'utilisateur dans la session
            $session->update($nom, $prenom, $email, $hashedPassword, $role, $id_user);
            $user = $page->getUserInfo($email);
            $session->add('user', $user);
            header("Location: profile.php");
            exit();
        } catch (\Exception $e) {
            $errors['database'] = $e->getMessage();
        }
    }
}


// Afficher la page de profil avec les informations de l'utilisateur
echo $page->render('profile.html.twig', ['user' => $user, 'errors' => $errors]);
?>
