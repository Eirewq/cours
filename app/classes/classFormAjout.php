<?php
namespace App;

class classFormAjout
{
    private $link;

    function __construct()
    {
        try {
            $this->link = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    function createCategorie($nomCategorie) {
        $query = "INSERT INTO categorie (nomCategorie, created_at, update_at) VALUES (:nomCategorie, NOW(), NOW())";
        $sth = $this->link->prepare($query);
        $sth->bindParam(':nomCategorie', $nomCategorie);
        return $sth->execute();
    }

    function createStatus($nomStatus) {
        $query = "INSERT INTO status (nomStatut, created_at, update_at) VALUES (:nomStatus, NOW(), NOW())";
        $sth = $this->link->prepare($query);
        $sth->bindParam(':nomStatus', $nomStatus);
        return $sth->execute();
    }

    function createUrgence($nomUrgence) {
        $query = "INSERT INTO urgence (nomUrgence, update_at) VALUES (:nomUrgence, NOW())";
        $sth = $this->link->prepare($query);
        $sth->bindParam(':nomUrgence', $nomUrgence);
        return $sth->execute();
    }
    
    
    
    
}
?>
