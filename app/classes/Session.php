<?php
namespace App;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add(string $key, array $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null; // Retourner null si la clé n'existe pas
    }

    public function isConnected() 
    {
        return isset($_SESSION['user']); // Vérifier si la clé 'user' est définie dans la session
    }

    public function hasRole(string $role)
    {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }

    public function destroy()
    {
        session_unset(); // Nettoyer toutes les variables de session
        session_destroy(); // Détruire la session
    }

    public function update(string $nom, string $prenom, string $email, string $password, string $role, int $id_user) {
        $sql = "UPDATE user     
                SET nom = :nom, prenom = :prenom, email = :email, password = :password, role = :role, update_at = NOW() 
                WHERE id_user = :id_user";
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }
    
}
?>
