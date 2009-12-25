<?php
	//display this page only if the user is connected
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id'])){
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		
		include PATH_LIB.'form.php';
		
		//Confirm deletetion form
		$form_delete_nabz = new Form('form_delete_nabz');
		
		$form_delete_nabz->method('POST');
		
		$form_delete_nabz->add('Submit','submit')
						->initial('Confirmer la suppression de mon lapin');
						
		if($form_delete_nabz->is_valid($_POST)){
			
			include PATH_MODEL.'nabz.php';
			$infos_nabz = read_infos_nabz($_SESSION['id']);
				
			$id_nabz = $infos_nabz['rabbit_id'];
			
			delete_nabz($id_nabz);
			include PATH_VIEW.'delete_nabz_done.php';
			
		}else{include PATH_VIEW.'form_delete_nabz.php';}
	}//end of user_connected
?>