<?php 

declare(strict_types=1);

//Import de Model
require_once 'Model.php';

//Notre class Upload, permet de récupérer les fichiers uploadés dans le formulaire
class Upload extends Model 
{
    protected string $table = 'uploads';

    //Méthode insert
    public function insert(array $params): void
    {
        try {
            $add = $this->database->prepare(
                "INSERT INTO {$this->table} (`animal_id`, `file_location`, `created_at`)
                VALUES (:animal_id, :file_location, :created_at)"
            );
            $add->execute($params);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

}