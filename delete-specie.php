<?php 

//Controller delete specie

//Models 
require_once 'services/Session.php';
require_once 'models/Model.php';
require_once 'models/Specie.php';


//Démarrage de la session
Session::start();

//On instancie notre classe
$id = $_GET['id'];
$specieModel = new Specie;

//Execution de la requete
$specieModel->delete($id);

header("Location: dashboard.php");
exit;