<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;

$page = new Page();
$session = new Session(); // Création de l'instance de Session

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashedPassword = $page->getPassword($email);
    if ($hashedPassword && password_verify($password, $hashedPassword)) {
        $user = $page->getUserInfo($email);
        if ($user) {
            // Ajouter les informations de l'utilisateur à la session
            $session->add('user', $user);
            if($user['role'] === 'Client'){
                header("Location: vueServiceClient.php");   
            } else {
                header("Location: planningGeneral.php");   
            }
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            $errors['database'] = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        $errors['database'] = "Adresse e-mail ou mot de passe incorrect.";
    }
}

echo $page->render('login.html.twig', ['errors' => $errors]);
?>
