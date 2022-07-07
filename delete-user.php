<?php 

//Controller delete user

//Models 
require_once 'services/Session.php';
require_once 'models/Model.php';
require_once 'models/User.php';


//Démarrage de la session
Session::start();

//On instancie notre classe
$id = $_GET['id'];
$userModel = new User;

//Execution de la requete
$userModel->delete($id);

header("Location: dashboard.php");
exit;