<?php 

declare(strict_types=1);

// Import de Model
require_once 'Model.php';
require_once 'User.php'; 

// Notre classe Post,nous servira pour la création et modification de notre article

class Post extends Model 
{
    protected string $table = "post";

    // Création de l'article
    public function insert(array $params): void {
        try {
            $add = $this->database->prepare(
                "INSERT INTO {$this->table} (`user_id`,`title`,`content`,`created_at`)
                VALUES (:user_id, :title, :content, :created_at)"
            );
            $add->execute($params);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    //Méthodes pour modifier nos articles de la base de données
    public function updatePost(string $title, string $content, string $id) {
        try {
            $update = $this->database->prepare(
                "UPDATE {$this->table} 
                SET title = :title, 
                content = :content 
                WHERE id = :id"
            );
            $update->execute([
                ':title' => $title,
                ':content' => $content,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}