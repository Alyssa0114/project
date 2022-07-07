<?php
//Force type hinting
declare(strict_types=1);

//import de Model
require_once 'Model.php';

//Notre classe Specie, nous servira pour la gestion des espèces
class Specie extends Model {
    protected string $table = 'specie';
    
    
     public function insert(array $params): void{
        try{
            if($this->findByName($params[':name'])){
                throw new PDOException("cette espèce existe déjà.");
            }else
            $add=$this->database->prepare(
                "INSERT INTO {$this->table} (name) 
                VALUES (:name)");
            $add->execute($params);
        }catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}