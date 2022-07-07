<?php

//Services
require_once 'services/Session.php';
Session::start();

echo "<p> Votre message a bien été envoyé ! </p>"; 
echo "<p> Redirection automatique vers la page d'accueil. </p>"; 

header('Refresh: 4; url=index.php');

require "views/contact_validation.phtml";