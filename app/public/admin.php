<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;
use App\classAdmin;

$page = new Page();
$session = new Session();
$admin = new classAdmin();

$table = isset($_POST['table']) ? $_POST['table'] : 'user';
$searchTerm = '';
$datas = $admin->selectAll($table, $searchTerm);

// Vérifier si l'utilisateur est connecté
if (!$session->isConnected()) {
    header('Location: index.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if (isset($_POST["userId"]) and isset($_POST["newRole"])) {
    $user_id = $_POST["userId"];
    $newRole = $_POST["newRole"];
    $admin->updateUserInfo($user_id, $newRole);
    header("Location: admin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
    $datas = $admin->selectAll($table, $searchTerm); // Passer le terme de recherche à la méthode selectAll
}


$urlActuelle = basename($_SERVER['PHP_SELF']);

// Récupérer les informations de l'utilisateur depuis la session
$user = $session->get('user');

echo $page->render('admin.html.twig', ['user' => $user, 'datas' => $datas, 'urlActuelle' => $urlActuelle, 'table' => $table]);
?>
