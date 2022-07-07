<?php
//Force type hinting
declare(strict_types=1);

//import de Model
require_once 'Model.php';

//Notre classe Race, nous servira pour la gestion des races
class Race extends Model {
    protected string $table = 'race';
    
    
     public function insert(array $params): void{
        try{
            if($this->findByName($params[':race'])){
                throw new PDOException("cette race existe déjà.");
            }else
            $add=$this->database->prepare(
                "INSERT INTO {$this->table} (race) 
                VALUES (:race)");
            $add->execute($params);
        }catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}