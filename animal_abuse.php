<?php

//* animal_abuse CONTROLLER *//
// Notre controller animal abuse nous permet l'envoi d'un signalement pour une maltraitance animal

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/Animal_abuse.php';

// Titre et chemin de la page 
$pageTitle = 'Signaler une maltraitance';
$pagePath = 'animal_abuse';

// Variables
$message = '';
$alertAbuse = new Animal_abuse;
$date = date('Y-m-d H:i:s');

if (!empty($_POST)) {
    //Extraction depuis notre post
    extract($_POST);
    //On fait une vérification avec un filtre d'email
    if (!filter_var($mail,FILTER_VALIDATE_EMAIL)) {
        echo "Veuillez saisir une adresse e-mail valide.";
    } else {
        //Insertion du message dans la base de données
        $alertAbuse->insert(
            [
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':mail' => $mail,
                ':address_zipcode_city' => $address_zipcode_city,
                ':phone' => $phone,
                ':accused_name' => $accused_name,
                ':accused_address' => $accused_address,
                ':accused_relationship' => $accused_relationship,
                ':animal_situation' => $animal_situation,
                ':created_at' => $date,
            ]);
        //Redirection vers contact_validation

        header("location: animal_abuse_validation.php");
        echo "Message envoyé";
    }
}

//Render de la vue
render(__DIR__."/views/$pagePath", compact('pageTitle'));