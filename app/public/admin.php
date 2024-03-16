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

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
    $datas = $admin->selectAll($table, $searchTerm); // Passer le terme de recherche à la méthode selectAll
}

if (isset($_POST["method"]) and isset($_POST["id"]) and isset($_POST["table"])) {
    $method = $_POST["method"];
    $table = $_POST["table"];
    $id = $_POST["id"];
    if($method == "delete"){
        $admin->delete($id,$table);
        header("Location: admin.php");
    } else {
        echo "t nulll";
    }
}

if (isset($_POST["method"]) and isset($_POST["idCategorie"])) {
    $method = $_POST["method"];
    $id_categorie = $_POST["idCategorie"];
    if($method == "edit"){
        $newCate = $_POST["newCate"];
        $admin->updateCategorie($id_categorie,$newCate);
        header("Location: admin.php");
    }
}

if (isset($_POST["method"]) and isset($_POST["idStatut"])) {
    $method = $_POST["method"];
    $id_statut = $_POST["idStatut"];
    if($method == "edit"){
        $newStatus = $_POST["newStatus"];
        $admin->updateStatut($id_statut,$newStatus);
        header("Location: admin.php");
    }
}

if (isset($_POST["method"]) and isset($_POST["idUrgence"])) {
    $method = $_POST["method"];
    $id_Urgence = $_POST["idUrgence"];
    if($method == "edit"){
        $newUrgence = $_POST["newUrgence"];
        $admin->updateUrgence($id_Urgence,$newUrgence);
        header("Location: admin.php");
    } elseif($method == "delete") {
        $newUrgence = $_POST["newUrgence"];
        $admin->deleteUrgence($id_Urgence,$newUrgence);
        header("Location: admin.php");
    }
}

$urlActuelle = basename($_SERVER['PHP_SELF']);

// Récupérer les informations de l'utilisateur depuis la session
$user = $session->get('user');

echo $page->render('admin.html.twig', ['user' => $user, 'datas' => $datas, 'urlActuelle' => $urlActuelle, 'table' => $table]);
?>
