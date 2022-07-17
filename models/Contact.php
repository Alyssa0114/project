<?php

declare(strict_types=1);

// Import de Model
require_once 'Model.php';

// Notre class Contact, permet de recevoir et de lire nos messages
class Contact extends Model
{
    protected string $table = "contact";

    public function insert(array $params): void
    {
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

    public function getTEST(int $nb1 = 0, int $nb2 = 4): array
    {
        try {
            $query = $this->database->prepare("SELECT * FROM {$this->table} LIMIT ?, ?");
            $query->bindValue(1, $nb1, PDO::PARAM_INT);
            $query->bindValue(2, $nb2, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
