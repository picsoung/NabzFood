<?php
	//display this page only if the user is connected
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id'])){
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		//if id is empty or in wrong format
		if(empty($_GET['id']) or !is_numeric($_GET['id']) )
		{
			include PATH_VIEW.'error_parameter_profile.php';
		}else{
			require_once(PATH_MODEL.'nabz.php');
			$infos_nabz = read_infos_nabz($_GET['id']);
			
			if($infos_nabz !== false) {
				
				$id_nabz = $infos_nabz['rabbit_id'];
				$nabz_serial = $infos_nabz['rabbit_serial'];
				$nabz_token = $infos_nabz['rabbit_token'];
				$nabz_name = $infos_nabz['rabbit_name'];
				$_SESSION['nabzname']=$nabz_name;
				$_SESSION['id_nabz']=$id_nabz;
				
				//extract skills of the nabz
				/*$skill_nabz = read_skill_nabz($id_nabz);
				
				$skill_angry = $skill_nabz['skill_angry'];
				$skill_thirst = $skill_nabz['skill_thirst'];
				$skill_health = $skill_nabz['skill_health'];*/
				
				include PATH_VIEW.'profile_nabz.php';
				
			}else{
				include PATH_VIEW.'error_null_nabz.php';
				}//end of infosnabz≠false
			} //end of empty id
	} // end !user_connected
		
?>