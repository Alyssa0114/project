<?php

//* REGISTER CONTROLLER *//
// Notre controller register nous permet l'insertion d'un utilisateur dans la base de données

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/User.php';

//Démarrage de la session 
Session::start();

// Titre et chemin de la page 
$pageTitle = 'Créer un compte';
$pagePath = 'register';

// Variables
$message = '';
$addNewUser = New User;

// Nous procédons à une série de vérifications
if(!empty($_POST)) {
    // Vérification du mail pour savoir si il n'éxiste pas déjà dans la base de données.
    if(array_key_exists('mail', $_POST) && !empty($_POST['mail'])) {
        //Si le mail n'existe on procède à l'extract depuis notre POST
        extract($_POST);
        // Vérification avec un filtre  du format mail
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo $message;
        } else {
            // On procède à l'insertion de l'utilisateur dans la base de données
            $addNewUser -> insert(
                [
                    //On associe les clés à leur valeurs
                    ':firstname' => $firstname,
                    ':lastname' => $lastname,
                    ':mail' => $mail,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':city' => $city,
                    ':zipcode' => $zipcode,
                    ':password' => password_hash($password, PASSWORD_DEFAULT)
                ]
            );
            //Redirection vers la page se connecter
            header('location: login.php');
        }
    }
} 

// Rendu de la vue
render(__DIR__."/views/$pagePath", compact('pageTitle'));