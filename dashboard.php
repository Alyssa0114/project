<?php

//* ADMIN PANEL CONTROLLER *//
// Notre controller dashboard nous servira d'affichage et la gestion pour notre dashboard

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/User.php';
require_once 'models/Post.php';
require_once 'models/Contact.php';
require_once 'models/Animal_abuse.php';
require_once 'models/Specie.php';
require_once 'models/Race.php';
require_once 'models/Animal.php';

//Démarrage de la session 
Session::start();

// Titre et chemin de la page 
$pageTitle = 'Panneau d\'administration';
$pagePath = 'dashboard';

// Variables
$id = $_SESSION['auth']['id'];
$date = date('d-m-Y');

$userModel = new User;
$users = $userModel->findAll();

$contactModel = new Contact;
$counts = $contactModel->countAll();

$specieModel = new Specie;
$countSpecies = $specieModel->countAll();
$species = $specieModel->findAll();

$postModel = new Post;
$countPosts = $postModel->countAll();

$raceModel = new Race;
$countRaces = $raceModel->countAll();
$races = $raceModel->findAll();

$animalModel = new Animal;
$countAnimals = $animalModel->countAll();
$animals = $animalModel->findAll();

// Rendu de la vue
render(__DIR__."/views/$pagePath", compact('pageTitle', 'users', 'counts', 'countSpecies', 'species', 'date', 'countPosts', 'countRaces', 'countAnimals', 'animals', 'races'));