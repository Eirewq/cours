<?php
namespace App;

class classMessage
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

    function getService($id_service){
        $sql = 'SELECT * FROM service WHERE id_service = :id_service';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_service', $id_service);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getClient($id_client){
        $sql = 'SELECT * FROM user WHERE id_user = :id_client';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_client', $id_client);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getStatut(){
        $sql = 'SELECT * FROM status';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function changeSatutService($id_statut){
        $sql = 'SELECT * FROM status WHERE id_statut = :id_statut';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_statut', $id_statut);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function updateSatutService($id_service, $id_statut)
    {
        $sql = "UPDATE service 
                SET id_status = :id_statut, update_at = NOW() 
                WHERE id_service = :id_service";
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_statut', $id_statut);
        $sth->bindParam(':id_service', $id_service);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getMessageService($id_service, $id_intervenant, $id_client){
        $sql = 'SELECT * FROM commentaire WHERE id_service = :id_service AND (id_user = :id_intervenant OR id_user = :id_client) ORDER BY created_at DESC;';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_service', $id_service);
        $sth->bindParam(':id_intervenant', $id_intervenant);
        $sth->bindParam(':id_client', $id_client);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function insertMessage($id_service, $id_user, $contenu){

        $id_service= intval($id_service);
        $id_user = intval($id_user);
        $contenu= strval($contenu);

        $sql = "INSERT INTO commentaire ( 
                                            id_service,
                                            id_user, 
                                            contenu,
                                            created_at
                                        )
                            VALUES      (
                                            :id_service,
                                            :id_user, 
                                            :contenu,
                                            NOW()
                                        )
                ";
        
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':id_service', $id_service, \PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->bindParam(':contenu', $contenu, \PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur d'insertion dans la base de données: " . $e->getMessage());
        }
    }
}
?>
