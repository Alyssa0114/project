<?php

//* ADD_POST CONTROLLER *//
// Notre controller va nous permettre d'ajouter un nouvel article

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/Post.php';

//Démarrage de la session 
Session::start();

// Titre et chemin de la page 
$pageTitle = 'Ajouter un article';
$pagePath = 'add_post';

// On instancie nos classes
$postModel = new Post;

$user_id = $_SESSION['auth']['id'];

if (!empty($_POST)) {
    // On fait un extract POST
    extract($_POST);
    // On insère l'article dans la base de données
    $posts = $postModel->insert(
        [
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $user_id,
            ':created_at' => date('Y-m-d H:i:s')
        ]
    );
    // On affiche un message de confirmation
    $_SESSION['success'] = 'L\'article a bien été ajouté';
} else {
    $_SESSION['error'] = 'Une erreur est survenue';
}


// On inclut la vue
render(__DIR__ . "/views/$pagePath", compact('pageTitle'));
