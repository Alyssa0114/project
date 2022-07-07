<?php

declare(strict_types=1);

// Import de Model
require_once 'Model.php';

// Notre class Animal_abuse, permet de signaler une maltraitance d'animaux
class Animal_abuse extends Model 
{
    protected string $table = "animal_abuse";

    public function insert(array $params): void {
        try {
            $add = $this->database->prepare(
                "INSERT INTO {$this->table} (`firstname`,`lastname`,`mail`,`address_zipcode_city`,`phone`,`accused_name`,`accused_address`,`accused_relationship`,`animal_situation`,`created_at`)
                VALUES (:firstname, :lastname, :mail, :address_zipcode_city, :phone, :accused_name, :accused_address, :accused_relationship, :animal_situation, :created_at)"
            );
            $add->execute($params);  
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}

