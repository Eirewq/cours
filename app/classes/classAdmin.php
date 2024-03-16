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
            if($table == 'user'){
                $sql .= " WHERE nom LIKE '%$searchTerm%' OR prenom LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
            } elseif($table == 'categorie') {
                $sql .= " WHERE nomCategorie LIKE '%$searchTerm%'";
            } elseif($table == 'status'){
                $sql .= " WHERE nomStatut LIKE '%$searchTerm%'";
            } elseif($table == 'urgence'){
                $sql .= " WHERE nomUrgence LIKE '%$searchTerm%'";
            }
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

    public function updateCategorie($id_categorie, $newCate){
        $sql = "UPDATE categorie 
        SET nomCategorie = :nomCategorie, update_at = NOW() 
        WHERE id_categorie = :id";
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nomCategorie', $newCate);
        $stmt->bindParam(':id', $id_categorie);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }

    public function updateUrgence($id_urgence, $newUrgence){
        $sql = "UPDATE urgence 
        SET nomUrgence = :nomUrgence, update_at = NOW() 
        WHERE id_urgence = :id";
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nomUrgence', $newUrgence);
        $stmt->bindParam(':id', $id_urgence);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }

    public function updateStatut($id_statut, $newStatut){
        $sql = "UPDATE status
        SET nomStatut = :nomStatut, update_at = NOW() 
        WHERE id_statut = :id";
        $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nomStatut', $newStatut);
        $stmt->bindParam(':id', $id_statut);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }

    public function delete($table, $id) {
        $allowedTables = ['user', 'categorie', 'urgence', 'status']; 
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Table non autorisée.");
        }
        if ($table === 'user') {
            $pdo = new \PDO('mysql:host=mysql;dbname=accordenergie', "root", "");
            $pdo->beginTransaction();
    
            try {
                $sql = "DELETE FROM service WHERE id_intervenant = :id_user OR id_client = :id_user OR id_standardiste = :id_user ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_user', $id);
                $stmt->execute();

                $sql = "DELETE FROM commentaire WHERE id_user = :id_user";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_user', $id);
                $stmt->execute();
    
                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
        } 
    }
    
}
?>
