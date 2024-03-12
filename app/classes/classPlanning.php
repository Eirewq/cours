<?php

namespace App;

use DateTime;

class classPlanning
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

    function getDatesSemaine($semaineActuel, $anneeActuelle) {
        $datePremierJour = new DateTime();
        $datePremierJour->setISODate($anneeActuelle, $semaineActuel);
        $datesSemaine = array();
        $datesSemaine[] = array(
            'date' => $datePremierJour->format('Y-m-d'),
            'jour' => $datePremierJour->format('l') 
        );
        $dateSuivant = clone $datePremierJour;
        for ($i = 1; $i < 7; $i++) {
            $dateSuivant->add(new \DateInterval('P1D'));
            $datesSemaine[] = array(
                'date' => $dateSuivant->format('Y-m-d'),
                'jour' => $dateSuivant->format('l') 
            );
        }
        $joursSemaineFrancais = array(
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        );
    
        foreach ($datesSemaine as &$date) {
            $date['jour'] = $joursSemaineFrancais[$date['jour']];
        }
    
        return $datesSemaine;
    }

    function getIntervenant($premiereDateSemaine, $derniereDateSemaine){
        $sql = 'SELECT DISTINCT nom, prenom, id_user 
                FROM user JOIN service 
                ON service.id_intervenant = user.id_user 
                WHERE service.dateIntervention 
                BETWEEN :premiereDateSemaine AND :derniereDateSemaine';
        $sth = $this->link->prepare($sql);
        $sth->execute([
            ':premiereDateSemaine' => $premiereDateSemaine,
            ':derniereDateSemaine' => $derniereDateSemaine,
        ]);

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getNombreServiceGeneral($premiereDateSemaine, $derniereDateSemaine) {
        $sql = 'SELECT COUNT(*) AS nombre_services, DATE(dateIntervention) AS jour, nom, prenom
                FROM service 
                JOIN user ON service.id_intervenant = user.id_user
                WHERE DATE(dateIntervention) BETWEEN :premiereDateSemaine AND :derniereDateSemaine 
                GROUP BY jour, id_intervenant';
        $sth = $this->link->prepare($sql);
        $sth->execute([
            ':premiereDateSemaine' => $premiereDateSemaine,
            ':derniereDateSemaine' => $derniereDateSemaine,
        ]);

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    
    function getService($date, $id_intervenant){
        $sql = 'SELECT * 
        FROM service 
        WHERE DATE(dateIntervention) = :date AND id_intervenant = :id_intervenant';
        $sth = $this->link->prepare($sql);
        $sth->bindParam(':date', $date);
        $sth->bindParam(':id_intervenant', $id_intervenant);
        $sth->execute(); 
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function getInfo($id_intervenant){
        $sql = 'SELECT * 
        FROM user 
        WHERE id_user = :id_intervenant';
        $sth = $this->link->prepare($sql);
        $sth->bindParam(':id_intervenant', $id_intervenant);
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
