<?php
namespace App;

class classAjoutService
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

    public function getCategorie(){
        $sql = 'SELECT * FROM categorie';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getIntervenant(){
        $sql = 'SELECT id_user, prenom, role FROM user WHERE role = "Intervenant"';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUrgence(){
        $sql = 'SELECT * FROM urgence';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getIdWithEmail($email){
        $sql = 'SELECT id_user FROM user WHERE email = :email';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->bindParam(':email', $email);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertService($id_intervenant, $id_client, $id_standardiste, $id_categorie, $id_urgence, $dateIntervention, $nomService, $heureFin, $heureDebut){
        // Convertir les valeurs en format int, time et date
        $id_intervenant = intval($id_intervenant);
        $id_client = intval($id_client);
        $id_standardiste = intval($id_standardiste);
        $id_categorie = intval($id_categorie);
        $id_urgence = intval($id_urgence);
        $dateIntervention = date('Y-m-d', strtotime($dateIntervention));
        $heureFin = date('H:i:s', strtotime($heureFin));
        $heureDebut = date('H:i:s', strtotime($heureDebut));
    
        $sql = "INSERT INTO service (
                                        id_intervenant, 
                                        id_client, 
                                        id_standardiste,
                                        id_categorie,
                                        id_urgence,
                                        id_status, 
                                        created_at, 
                                        dateIntervention,
                                        nomService,
                                        heureFin, 
                                        heureDebut, 
                                        update_at
                                    ) 
                            VALUES  (
                                        :id_intervenant, 
                                        :id_client, 
                                        :id_standardiste,
                                        :id_categorie,
                                        :id_urgence,
                                        1, 
                                        NOW(), 
                                        :dateIntervention,
                                        :nomService,
                                        :heureFin, 
                                        :heureDebut, 
                                        NOW()
                                    )
                ";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':id_intervenant', $id_intervenant, \PDO::PARAM_INT);
        $stmt->bindParam(':id_client', $id_client, \PDO::PARAM_INT);
        $stmt->bindParam(':id_standardiste', $id_standardiste, \PDO::PARAM_INT);
        $stmt->bindParam(':id_categorie', $id_categorie, \PDO::PARAM_INT);
        $stmt->bindParam(':id_urgence', $id_urgence, \PDO::PARAM_INT);
        $stmt->bindParam(':dateIntervention', $dateIntervention);
        $stmt->bindParam(':nomService', $nomService);
        $stmt->bindParam(':heureFin', $heureFin);
        $stmt->bindParam(':heureDebut', $heureDebut);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur d'insertion dans la base de données: " . $e->getMessage());
        }
    }
    
}
?>
