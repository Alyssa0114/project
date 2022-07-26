<?php

// Services
require_once 'services/utils.php';
require_once "services/Session.php";

// Models
require "models/Specie.php";
require_once 'models/Animal.php';
require_once 'models/Post.php';

// Session
Session::start();

// Titre de la page
$pageTitle = "Accueil";
$pagePath = "index";

// Variables
$specie = new Specie;
$animalModel = new Animal;
$postModel = new Post;

//qsddsqdssdq
// AJOUT TEST
// Methode
$findSpecies = $specie->findAll();
$animals = $animalModel->getAllAnimal();
$posts = $postModel->findAll();
$countPosts = $postModel->countAll();

if (!empty($_POST)) {
    extract($_POST);
    $specie->insert(
        [
            ':name' => $name
        ]
    );
    header('Location: index.php');
    echo "Ajout d'espèce";
    exit;
}


$countAnimals = $animalModel->countAll();


// Rendu de la vue
render(__DIR__ . "/views/$pagePath", compact('pageTitle', 'findSpecies', 'countAnimals', 'animals', 'posts','countPosts'));
