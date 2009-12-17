<?php
	//Only display this page is user is connected
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id'])){
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		
		include PATH_LIB.'form.php';
		
		//Add Nabz form
		$form_add_nabz = new Form('form_add_nabz');
		
		$form_add_nabz->method('POST');
	
		$form_add_nabz->add('Text','serial')
					->label("Serial");
					
		$form_add_nabz->add('Text','token')
					->label("Token");
		$form_add_nabz->add('Submit','submit')
				->value("Valider");
				
		$form_add_nabz->bound($_POST);			
		
		//array  for errors
		$error_nabz = array();
		
		if($form_add_nabz->is_valid($_POST))
		{
			
			if(empty($error_nabz))
			{
				//Try to add a new user in the db
			list($nabz_serial,$nabz_token) = $form_add_nabz->get_cleaned_data('serial','token');
			
			// On veut utiliser le modele de l'nabz (~/models/nabz.php)
			include PATH_MODEL.'nabz.php';
			
			if(nabz_exists($nabz_serial,$nabz_token)==true) {
				$id_nabz = add_nabz_in_db($nabz_serial, $nabz_token, $_SESSION['id']);
				
				//Look if the nab is not already added.
				if (ctype_digit($id_nabz)) {
					//display confirmation of addition
					
					init_nabz_skill($id_nabz);
				include PATH_VIEW.'add_nabz_done.php';
				
					}else {
							$error =& $id_nabz;
						
							if (23000 == $error[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL
								preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_pb);
								$value_pb = $value_pb[1];
				
								if ($nabz_serial == $value_pb) {
				
									$error_nabz[] = "Ce serial est déjà utilisé.";
								} else {
				
									$error_nabz[] = "Ce token est déjà utilisé.";
								}
							} else {
								$error_nabz[] = sprintf("Ce serial est déjà utilisé.");
							}
							
							// On reaffiche le formulaire d'ajout
							include PATH_VIEW.'form_add_nabz.php';
							
					}//end of ctypedigit
				}else{
					$error_nabz[] = "Couple token-serial invalide.";
					include PATH_VIEW.'form_add_nabz.php';}//end of nabz_exist
			}else{include PATH_VIEW.'form_add_nabz.php';}//end of empty error
		}else{include PATH_VIEW.'form_add_nabz.php';}//end form valid
	}//end of user_connected

?>