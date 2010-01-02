<?php

// Suppression de toutes les variables et destruction de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('id', '',0,'/');
setcookie('auto_login', '',0,'/');

include PATH_VIEW.'logout_ok.php';

?>