<?php
//only display this page if user is connected
	if(!user_connected()) {
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else {
		//Delete sessions
		$_SESSION = array();
		session_destroy();
		
		//Suppress cookies for autologin
		setcookie('id','',0);
		setcookie('auto_login','',0);
		
		include PATH_VIEW.'signout_ok.php';
	} 
?>
