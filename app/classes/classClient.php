<?php
namespace App;

class classClient
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

    function getService($id_user){
        $sql = 'SELECT * FROM service WHERE id_client = :id_user';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':id_user', $id_user);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getIntervenant(){
        $sql = 'SELECT * FROM user WHERE role = "Intervenant"';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getUrgence(){
        $sql = 'SELECT * FROM urgence';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
