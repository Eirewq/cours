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
}
?>
