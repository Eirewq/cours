<?php
namespace App;

class classModifBase
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
    
}
?>
