<?php

//* CONTACT CONTROLLER *//
// Notre controller contact nous permet l'envoi de message

// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/Contact.php';

// Titre et chemin de la page 
$pageTitle = 'Nous contacter';
$pagePath = 'contact';

// Variables
$message = '';
$sendMessage = new Contact;
$date = date('Y-m-d H:i:s');

if (!empty($_POST)) {
    //Extraction depuis notre post
    extract($_POST);
    //On fait une vérification avec un filtre d'email
    if (!filter_var($mail,FILTER_VALIDATE_EMAIL)) {
        echo "Veuillez saisir une adresse e-mail valide.";
    } else {
        //Insertion du message dans la base de données
        $sendMessage->insert(
            [
                ':name' => $name,
                ':mail' => $mail,
                ':phone' => $phone,
                ':subject' => $subject,
                ':content' => $content,
                ':created_at' => $date,
            ]);
        //Redirection vers contact_validation

        header("location: contact_validation.php");
        echo "Message envoyé";
    }
}

//Render de la vue
render(__DIR__."/views/$pagePath", compact('pageTitle'));