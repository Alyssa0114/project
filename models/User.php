<?php

declare(strict_types=1);

// Import de Model
require_once 'Model.php';

// Notre class user, permet la création d'un compte utilisateur
class User extends Model 
{
    protected string $table = "user";

    //Implémentation de la méthode abstract insert().
    public function insert(array $params): void {
        //On utilise la méthode findByEmail, afin de vérifier que l'user n'existe pas déjà dans la base de données
        try {
            if ($this->findByEmail($params[':mail'])) {
                throw new PDOException("Votre adresse email est déjà utilisée");
            } else {
                //Insertion du nouvel utilisateur dans la base de données
                $add = $this->database->prepare(
                    "INSERT INTO {$this->table} (`firstname`, `lastname`, `mail`, `phone`, `address`, `city`, `zipcode`, `password`)
                    VALUES (:firstname, :lastname, :mail, :phone, :address, :city, :zipcode, :password)");
                    //On exécute nos éléments du tableau $params 
                    $add->execute($params);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    //  Méthode findByEmail, vérification de l'émail dans la base de données
    public function findByEmail(string $mail){
        try{
            $find = $this->database->prepare(
                "SELECT * FROM {$this->table}
                WHERE mail = :mail"
            );
            $find->execute([':mail' => $mail]);
            $result = $find->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $result;
    }

    // la méthode rôle nous servira a attribuer le role admin a un utilisateur
    //public function role(string $isAdmin, string $idUser) {

    //}

}
