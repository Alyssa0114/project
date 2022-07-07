<?php 

//Controller delete specie

//Models 
require_once 'services/Session.php';
require_once 'models/Model.php';
require_once 'models/Race.php';


//Démarrage de la session
Session::start();

//On instancie notre classe
$id = $_GET['id'];
$raceModel = new Race;

//Execution de la requete
$raceModel->delete($id);

header("Location: dashboard.php");
exit;