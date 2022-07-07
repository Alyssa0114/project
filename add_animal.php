<?php

//* ADD ANIMAL CONTROLLER *//
// Notre controller contact nous permet l'ajout d'un animal dans la base de données

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/Animal.php';
require_once 'models/Race.php';
require_once 'models/Specie.php';
require_once 'models/Upload.php';

//Démarrage de la session 
Session::start();

// Titre et chemin de la page 
$pageTitle = 'Ajouter un animal';
$pagePath = 'add_animal';




//Format de la date de naissance
date_default_timezone_set('Europe/Paris');
$date = date('d-m-Y');

//On instancie nos classes
$animalModel = new Animal;
$raceModel = new Race;
$specieModel = new Specie;
$uploadModel = new Upload;

//On utilise findAll() pour récupérer les champs requis depuis nos tables
$races = $raceModel->findAll();
$species = $specieModel->findAll();

if (!empty($_POST)) {
    //On fait un extract POST 
    extract($_POST);
    //Paramètres de l'Upload
    //On créer un nouveau dossier pour chaque animal


    //On insère l'animal dans la base de données
    $animals = $animalModel->insert(
        [
            ':name' => $name,
            ':date_of_birth' => $_POST['date_of_birth'],
            ':sex' => $_POST['sex'],
            ':refuge' => $refuge,
            ':specie_id' => $specie_id,
            ':race_id' => $race_id,
            ':animal_code_id' => intval($animal_code_id),
            ':created_at' => date('d-m-Y H:i:s')
        ]
    );
    //Upload configuration
    $folderName = array_column($species, 'name', 'id')[$specie_id];
    $targetDir = "public/assets/images/uploads/$folderName/";
    $dirExists = is_dir($targetDir);
    if (!$dirExists) {
        mkdir($targetDir, 0755);
    }

    //On génère un compteur 
    $counter = count($_FILES['files']['name']);
    //On boucle sur le nombre de fichiers
    for ($i = 0; $i < $counter; $i++) {
        //On définit les paramètres de l'Upload 
        $fileName = basename($_FILES['files']['name'][$i]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');

        //On vérifie si le fichier existe déjà
        if (file_exists($targetFilePath)) {
            $_SESSION['error'] = 'Le fichier existe déjà';
        }

        if (in_array($fileType, $allowTypes) && $counter <= 3) {
            //On déplace le fichier 
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFilePath)) {
                //On insert l'image dans la base de données
                $uploadModel->insert(
                    [
                        ':animal_id' => $animals,
                        ':file_location' => $targetFilePath,
                        ':created_at' => date('d-m-Y H:i:s')
                    ]
                );
                //On affiche un message de succès
                $_SESSION['success'] = 'Le fichier a été uploadé avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'enregistrement de la fiche animal, veuillez réessayer';
                header('Location:add_animal.php');
                exit;
            }
        }
    }
}

//On inclut la vue
render(__DIR__ . "/views/$pagePath", compact('pageTitle', 'species', 'races'));
