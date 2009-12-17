<?php
	//only display this page if user is connected
	if (!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id']))
	{
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		include PATH_LIB.'form.php';
		
		//extract infos about the nabz
		//$infos_nabz = read_infos_nabz($_GET['id']);
		
		//Edit infos form
		$form_edit_infos = new Form('form_edit_infos');
		
		$form_edit_infos->method('POST');
		
		$form_edit_infos->add('Email','email_addr')
					->label('Votre adresse e-mail')
					->Required(false)
					->value($_SESSION['email']);
					
		$form_edit_infos->add('Submit','submit')
					->initial('Modifier ces informations');
					
		//Edit password form
		
		$form_edit_password = new Form('form_edit_password');
		
		$form_edit_password->method('POST');
		
		$form_edit_password->add('Password','old_password')
					->label('Votre ancien mot de passe');
		
		$form_edit_password->add('Password','new_password')
					->label('Votre nouveau mot de passe');
					
		$form_edit_password->add('Password','verif_new_password')
						->label('Confirmation nouveau mot de passe');
		
		$form_edit_password->add('Submit','submit')
						->initial('Modifier mon mot de passe');
		
		//Errors array				
		$errors_form_infos = array();
		$errors_form_password = array();
		
		//Message array
		if(!empty($_POST['message'])){$msg_confirm=$_POST['message'];}//Retrieve the message confirmation if is not empty
		 
				
		if($form_edit_infos->is_valid($_POST))
		{
			$email_addr = $form_edit_infos->get_cleaned_data('email_addr');
			
			//user wants to update his email
			if(!empty($email_addr))
			{
				$test = update_mail_user($_SESSION['id'],$email_addr);
				if($test == true)
				{
					$msg_confirm = "Votre nouvelle adresse email a bien été prise en compte.";
					$_SESSION['email']=$email_addr;
					header("Location: index.php?module=members&action=edit_profile&id=".$_SESSION['id']."&message=".$msg_confirm); //Reload page
				} else {// if this email addr is already taken
					$error =& $test;
					
						if (23000 == $error[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL
							preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_pb);
							$value_pb = $value_pb[1];
			
							if ($email_addr == $value_pb) {
			
								$errors_form_infos[] = "Cette adresse e-mail est déjà utilisée.";
							} else {
			
								$errors_form_infos[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
							}
						} else {
							$errors_form_infos[] = sprintf("Cette adresse e-mail est déjà utilisée.");
						}
				}				
			}//end test !empty email_addr
		} else if ($form_edit_password->is_valid($_POST))
		{
			//same password test
			if($form_edit_password->get_cleaned_data('new_password') != $form_edit_password->get_cleaned_data('verif_new_password'))
			{
				$errors_form_password[]="Les deux mots de passes entrés sont différents";
			}else{
				$new_password = $form_edit_password->get_cleaned_data('new_password');
				update_password_user($_SESSION['id'],$new_password);
				
				$msg_confirm="Votre mot de passe a correctement été mis à jour.";
			}
			
			
			}//end of is_valid($Post)
			
			include PATH_VIEW.'form_edit_profile.php';
	}//end of !user_connected
?>