<?php
namespace App;

class classAdmin
{
    public function selectAll($table, $searchTerm = '')
    {
        $validTables = ['user', 'urgence', 'status', 'categorie', ];
        if (!in_array($table, $validTables)) {
            throw new Exception("Nom de table invalide.");
        }

        $sql = "SELECT * FROM $table";
        if (!empty($searchTerm)) {
            $sql .= " WHERE nom LIKE '%$searchTerm%' OR prenom LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
        }
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie', "root", "");
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    

    public function updateUserInfo(int $id, string $role): void
    {
        $sql = "UPDATE user 
                SET role = :role, update_at = NOW() 
                WHERE id_user = :id";
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }
}
?>
