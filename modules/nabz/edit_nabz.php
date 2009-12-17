<?php
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id']))
	{
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		include PATH_LIB.'form.php';
		
		//extract infos about nabz
		include PATH_MODEL.'nabz.php';
		$infos_nabz = read_infos_nabz($_GET['id']);
		
		//Edit infos nabz form
		$form_edit_nabz = new Form('form_edit_nabz');
		
		$form_edit_nabz->method('POST');
		
		$form_edit_nabz->add('Text','serial')
						->label("Serial")
						->value($infos_nabz['rabbit_serial']);
		
		$form_edit_nabz->add('Text','token')
						->label("Token")
						->value($infos_nabz['rabbit_token']);
						
		$form_edit_nabz->add('Submit','submit')
						->initial("Modifier ces informations");
						
		//array for errors
		$error_edit = array();
		
		if($form_edit_nabz->is_valid($_POST))
		{
			$nabz_serial = $form_edit_nabz->get_cleaned_data('serial');
			$nabz_token = $form_edit_nabz->get_cleaned_data('token');
			
			if(!empty($nabz_serial) or !empty($nabz_token))
			{
				$test = update_infos_nabz($_SESSION['id'],$nabz_serial,$nabz_token);
				
					if($test == true)
					{
						$msg_confirm = "Changement(s) pris en compte.";
					} else {// if this email addr is already taken
						$error =& $test;
						
							if (23000 == $error[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL
								preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_pb);
								$value_pb = $value_pb[1];
				
								if ($nabz_token == $value_pb) {
				
									$error_edit[] = "Ce token ou ce serial est déjà utilisé.";
								} else {
				
									$error_edit[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
								}
							} else {
								$error_edit[] = sprintf("Ce token ou ce seirla est déjà utilisé.");
							}
					}//end test=true
				}//end of empty
			}//end of is_valid
		include PATH_VIEW.'form_edit_nabz.php';
	}//end of user_connected
?>