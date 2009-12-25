<?php
	//only display this page if user is connected
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id'])) {
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else {
			//if id is not specified or in the wrong format
			if (empty($_GET['id']) or !is_numeric($_GET['id']))
			{
				include PATH_VIEW.'error_parameter_profile.php';
			}else {
				$infos_user = read_infos_user($_SESSION['id']);
				
				if (false !== $infos_user && $infos_user['hash_validation'] == '')
				{
					$username = $infos_user['user_pseudo'];
					$email_addr = $infos_user['user_mail'];
					$lastconnect = $infos_user['user_lastconnect'];
					$_SESSION['email']=$email_addr;
					include PATH_VIEW.'profile_user.php';
				}else {
					include PATH_VIEW.'error_null_profile.php';
				}
			}
		
	}
?>