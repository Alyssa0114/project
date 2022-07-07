<?php

declare(strict_types=1);

// Import de Model
require_once 'Model.php';

// Notre class Contact, permet de recevoir et de lire nos messages
class Contact extends Model 
{
    protected string $table = "contact";

    public function insert(array $params): void {
        try {
            $add = $this->database->prepare(
                "INSERT INTO {$this->table} (`name`,`mail`,`phone`,`subject`,`content`,`created_at`)
                VALUES (:name, :mail, :phone, :subject, :content, :created_at)"
            );
            $add->execute($params);  
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}

