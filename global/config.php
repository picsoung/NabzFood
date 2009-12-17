<?php

// Identifiants pour la base de données. Nécessaires a PDO2.
define('SQL_DSN',      'mysql:dbname=nabdb;host=localhost');
define('SQL_USERNAME', 'root');
define('SQL_PASSWORD', 'root');

define('CASH_START', 100);
define('PATH_MODEL', './models/');
define('PATH_LIB', './libs/');
define('PATH_GLOBAL_VIEW', './global_view/');

// Chemins à utiliser pour accéder aux vues/modeles/librairies
$module = empty($module) ? !empty($_GET['module']) ? $_GET['module'] : 'index' : $module;
define('PATH_VIEW',    './modules/'.$module.'/view/');

//API violet
define ('API_URL', 'http://api.violet.net/vl/FR/');

//PATH for img of products in the Rabbit store
define('PATH_IMAGE_STORE','http://localhost:8888/NabzfoodTX20/images/store/');
define('PATH_IMAGE_RESSOURCE','http://localhost:8888/NabzfoodTX20/images/ressources/');
?>