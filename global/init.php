<?php

// Inclusion du fichier de configuration (qui définit des constantes)
include 'global/config.php';

// Utilisation et démarrage des sessions
session_start();

// Désactivation des guillemets magiques
ini_set('magic_quotes_runtime', 0);
set_magic_quotes_runtime(0);

if (1 == get_magic_quotes_gpc())
{
	function remove_magic_quotes_gpc(&$value) {
	
		$value = stripslashes($value);
	}
	array_walk_recursive($_GET, 'remove_magic_quotes_gpc');
	array_walk_recursive($_POST, 'remove_magic_quotes_gpc');
	array_walk_recursive($_COOKIE, 'remove_magic_quotes_gpc');
}

// Inclusion de Pdo2, potentiellement utile partout
include PATH_LIB.'pdo2.php';

//is user connected ?
function user_connected() {

	return !empty($_SESSION['id']);
	}

	include PATH_MODEL.'members.php';
	
	//User not connected but got autologin cookie
	if(!user_connected() && !empty($_COOKIE['id']) && !empty($_COOKIE['auto_login']))
	{
		echo 'not connected'.$_COOKIE['id'];
		$infos_user = read_infos_user($_COOKIE['id']);
		
		if(false !== $infos_user)
		{
				$browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
			$hash = sha1('592a23516c'.$infos_user['user_pseudo'].'3b665d692a'.$infos_user['user_pass'].'307e352c2b'.$browser.'7e79437856');
			
				if($_COOKIE['auto_login'] == $hash)
				{		
					// On enregistre les informations dans la session
					$_SESSION['id']     = $_COOKIE['id'];
					$_SESSION['pseudo'] = $infos_user['user_pseudo'];
					$_SESSION['email']  = $infos_user['user_mail'];
				}
		}
	}
	
//is user admin ?
function user_admin() {

	$infos_user = read_infos_user($_SESSION['id']);
	
	if(false !== $infos_user)
	{
		if($infos_user['user_pseudo'] == 'nicolas.grenie')
		{
			return true;
		}else{
			return false;}
		}
	}

//user have a nabz ?
function user_has_nabz($usr_nabz)
{
	$pdo = PDO2::getInstance();
	
	$query=$pdo->prepare("SELECT rabbit_id FROM tbl_rabbit WHERE rabbit_usr_id = :user_id");
	$query->bindValue(":user_id", $usr_nabz);
	
	$query->execute();
	
	if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['rabbit_id'];
		}
	return false;
}

//is user try to get a page that is not his
function verify_get_id($id_get,$id_session)
{
	if($id_get != $id_session)
	{
		return false;
	}else{
		return true;
	}
}
?>