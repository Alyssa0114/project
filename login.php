<?php

//* LOGIN CONTROLLER *//
// Notre controller register nous permet l'insertion d'un utilisateur dans la base de données

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/User.php';

// Titre et chemin de la page 
$pageTitle = 'Se connecter';
$pagePath = 'login';

// Variables
$message = '';
$userSignIn = New User;

try {
    if (!empty($_POST)) {
        extract($_POST);
        //Vérification si l'utilisateur existe dans la base de données
        $user = $userSignIn->findByEmail($mail);
        if (empty($user)) {
            throw new DomainException("Ce compte utilisateur n'existe pas.");
        } else {
            //Si l'utilisateur existe dans notre base de données nous procédons à la vérification du mot de passe.
            //On utilise password_verify afin de vérifier si le password existe
            if (password_verify($password, $user['password'])) {
                //Si le password est correct nous procédons à la connexion
                // Puis on enregistre dans la session
                Session::start();
                Session::init(
                    $user['id'],
                    $user['firstname'],
                    $user['lastname'],
                    $mail,
                    $user['phone'],
                    $user['address'],
                    $user['city'],
                    $user['zipcode'],
                    $user['isAdmin']
                );
                Session::setError();
                echo json_encode(['auth' => $user]);
                echo ('Vous êtes connecté');
                header("location:index.php");
                exit();
            } else {
                //Si le password est incorrect
                throw new DomainException("Mot de passe incorrect");
            }
        }
    }
} catch (DomainException $e){
    echo $e->getMessage();
}

//Rendu de la vue.

render(__DIR__."/views/$pagePath", compact('pageTitle'));