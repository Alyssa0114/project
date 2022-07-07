<?php 

declare(strict_types=1);


//class Model
//Elle nous permet d'établir la connexion en PDO

abstract class Model {
    protected $database;
    protected string $table;
    
    //Connexion à notre base de données 
    public function __construct() {
        try {
            $this->database = new PDO(
                'mysql:host=localhost;dbname=animals_project;charset=UTF8',
                'root',
                '',
                    [
                      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    //Introduction des comportements obligatoire
    abstract public function insert(array $params);
    
     // Méthode delete.
    public function delete(int $id): void
    {
        try {
            //suppression de l'id correspond à notre recherche
            $find = $this->database->prepare(
                "DELETE FROM {$this->table} WHERE id = :id"
            );
            $find->execute([':id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    // Méthode findAll.
    public function findAll(): ?array
    {
        try {
            $query = $this->database->query("Select * from {$this->table}");
            $result = $query->fetchAll();

            return $result ?? [];
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    // Méthode de recherche par id.
    public function findById(int $id)
    {
        try {
            $request = $this->database->prepare("
              SELECT *
              FROM {$this->table}
              WHERE id = :id
              ");
            $request->execute([':id' => $id]);
            $result = $request->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
        return $result;
    }

    // Méthode countAll, afficher le nombre total de messages/utilisateurs/animaux/etc...
    public function countAll():int {
        try {
            $find = $this->database->prepare(
                "SELECT COUNT(id) AS count 
                FROM {$this->table}"
            );
            $find->execute();
            $result = $find->fetch(); 
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return (int) $result['count'];
    }
    //Méthode pour rechercher par noms
    public function findByName(string $name) {
        try{
            $find = $this->database->prepare(
                "SELECT name FROM {$this->table} WHERE name = :name"
                );
                $find->execute([':name' => $name]);
                $result = $find->fetch();
        }catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $result;
    }

    //Afficher nos messages par ordre chronologique
    public function getMSG() {
        try {
            $find = $this->database->prepare(
                "SELECT * FROM {$this->table} ORDER BY created_at DESC"
            );
            $find->execute();
            $result = $find->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $result;
    }
    
}


