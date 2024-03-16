<?php
namespace App;

class classAdmin
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new \PDO('mysql:host=mysql;dbname=accordenergie', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }
    }

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
    
    function delete($Id, $table) {
        $allowedTables = ['user', 'categorie', 'urgence', 'status']; 
        if (!in_array($table, $allowedTables)) {
            throw new Exception("Table non autorisée.");
        }
        if($table == 'user'){
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("DELETE FROM commentaire WHERE id_user = :userId");
                $stmt->bindParam(':userId', $Id);
                $stmt->execute();
                
                $stmt = $this->db->prepare("DELETE FROM service WHERE id_intervenant = :userId");
                $stmt->bindParam(':userId', $Id);
                $stmt->execute();

                $stmt = $this->db->prepare("DELETE FROM service WHERE id_client = :userId");
                $stmt->bindParam(':userId', $Id);
                $stmt->execute();

                $stmt = $this->db->prepare("DELETE FROM service WHERE id_standardiste = :userId");
                $stmt->bindParam(':userId', $Id);
                $stmt->execute();                
                
                $stmt = $this->db->prepare("DELETE FROM user WHERE id_user = :userId");
                $stmt->bindParam(':userId', $Id);
                $stmt->execute();
    
                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                $this->db->rollBack();
                return false;
            }
        } elseif($table == 'categorie'){
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("DELETE FROM service WHERE id_categorie = :id_categorie");
                $stmt->bindParam(':id_categorie', $Id);
                $stmt->execute();
                
                $stmt = $this->db->prepare("DELETE FROM categorie WHERE id_categorie = :id_categorie");
                $stmt->bindParam(':id_categorie', $Id);
                $stmt->execute();
    
                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                throw new \Exception("Erreur de suppression dans la base de données: " . $e->getMessage());
                $this->db->rollBack();
                return false;
            }
        } elseif($table == 'status'){
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("DELETE FROM service WHERE id_status = :id_status");
                $stmt->bindParam(':id_status', $Id);
                $stmt->execute();
                
                $stmt = $this->db->prepare("DELETE FROM status WHERE id_statut = :id_status");
                $stmt->bindParam(':id_status', $Id);
                $stmt->execute();
    
                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                throw new \Exception("Erreur de suppression dans la base de données: " . $e->getMessage());
                $this->db->rollBack();
                return false;
            }
        } elseif($table == 'urgence'){
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("DELETE FROM service WHERE id_urgence = :id_urgence");
                $stmt->bindParam(':id_urgence', $Id);
                $stmt->execute();
                
                $stmt = $this->db->prepare("DELETE FROM urgence WHERE id_urgence = :id_urgence");
                $stmt->bindParam(':id_urgence', $Id);
                $stmt->execute();
    
                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                throw new \Exception("Erreur de suppression dans la base de données: " . $e->getMessage());
                $this->db->rollBack();
                return false;
            }
        }
    }
    
}
?>
