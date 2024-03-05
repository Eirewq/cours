<?php

namespace App;

class Page
{
    private \Twig\Environment $twig;
    private $link;
    public $session;

    function __construct()
    {
        $this->session = new Session();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',
            'debug' => true
        ]);
        try {
            $this->link = new \PDO('mysql:host=mysql;dbname=accordenergie',"root","");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function insert(string $table_name, array $data)
    {
        $sql = 'INSERT INTO ' . $table_name .'(email,password) VALUES (:email, :password)';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth -> execute($data);
    }
    
    public function render(string $name, array $data) :string
    {
        return $this->twig->render($name, $data);
    }

    public function checkEmailExists(string $email): bool
    {
        $query = "SELECT COUNT(*) FROM user WHERE email = :email";
        $stmt = $this->link->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        return $count > 0;
    }

    public function insertUser(string $email, string $hashedPassword): void
    {
        $sql = "INSERT INTO user (created_at, email, password, update_at) VALUES (NOW(), :email, :password, NOW())";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur d'insertion dans la base de données: " . $e->getMessage());
        }
    }

    public function updateUserInfo(string $nom, string $prenom, string $email): void
    {
        $sql = "UPDATE user     
                SET nom = :nom, prenom = :prenom, update_at = NOW() 
                WHERE email = :email";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
    
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }

    public function updateProfile(string $email, string $hashedPassword, string $nom, string $prenom, string $role): void // a faire 
    {
        $sql = "UPDATE user 
            SET nom = :nom, prenom = :prenom, nom = :nom, prenom = :prenom,nom = :nom, prenom = :prenom, update_at = NOW() 
            WHERE email = :email";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }

    }

    public function getPassword(string $email): ?string
    {
        $query = "SELECT password FROM user WHERE email = ?";
        $stmt = $this->link->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }

    public function getUserInfo(string $email): ?array
    {
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->link->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update(string $nom, string $prenom, string $email, string $password, string $role, int $id_user) {
        $sql = "UPDATE user     
                SET nom = :nom, prenom = :prenom, email = :email, password = :password, role = :role, update_at = NOW() 
                WHERE id_user = :id_user";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
    
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Erreur de mise à jour dans la base de données: " . $e->getMessage());
        }
    }
    
}