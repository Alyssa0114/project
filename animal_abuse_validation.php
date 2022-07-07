<?php

//Services
require_once 'services/Session.php';
Session::start();

echo "<p> Votre signalement a bien été envoyé ! </p>"; 
echo "<p> Redirection automatique vers la page d'accueil. </p>"; 

header('Refresh: 4; url=index.php');

require "views/animal_abuse_validation.phtml";