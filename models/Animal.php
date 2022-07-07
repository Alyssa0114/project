<?php

declare(strict_types=1);

// Import de Model
require_once 'Model.php';
require_once 'Specie.php';
require_once 'Race.php';

//Notre class Animal, qui nous servira à la création du profil d'un animal a adopter dans la base de données

class Animal extends Model
{
    protected string $table = "animal";

    public function insert(array $params)
    {
        try {
            if ($this->checkAnimalCodeId($params[':animal_code_id'])) {
                throw new PDOException("La fiche de cet animal existe déjà");
            } else {
                $add = $this->database->prepare(
                    "INSERT INTO {$this->table} (`name`, `date_of_birth`,`sex`,`refuge`,`specie_id`, `race_id`,`animal_code_id`,`created_at`)
                    VALUES (:name, :date_of_birth, :sex, :refuge, :specie_id, :race_id, :animal_code_id, :created_at)"
                );
                $add->execute($params);
                return $this->database->lastInsertId();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
    //Méthode pour nous permettre de vérifier si un animal est déjà enregistré
    function checkAnimalCodeId(int $animal_code_id)
    {
        try {
            $find = $this->database->prepare(
                "SELECT animal_code_id, name FROM {$this->table} WHERE animal_code_id = :animal_code_id"
            );
            $find->execute([
                ':animal_code_id' => $animal_code_id,
            ]);
            $result = $find->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $result;
    }

    public function getAllAnimal()
    {
        try {
            $find = $this->database->prepare(
                "SELECT animal.id, animal.name, animal.date_of_birth, animal.sex, animal.refuge, animal.specie_id, animal.race_id, animal.animal_code_id, animal.is_adopted_id, animal.created_at, GROUP_CONCAT(`file_location` SEPARATOR ', ') AS files 
        FROM $this->table 
        INNER JOIN uploads ON animal.id = uploads.animal_id GROUP BY id"
            );
            $find->execute();
            $result = $find->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }
}
