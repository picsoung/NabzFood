<?php
//only display this page if user is not connected
	if(user_connected()) {
		include PATH_GLOBAL_VIEW.'error_already_connected.php';
	}else {?>

<?php
	include PATH_LIB.'form.php';
	
	//Signup Form
	$form_signup = new Form('form_signup');
	
	$form_signup->method('POST');
	
	$form_signup->add('Text','username')
				->label("Votre nom d'utilisateur");
				
	$form_signup->add('Password','password')
				->label("Votre mot de passe");
	
	$form_signup->add('Password','password_verif')
				->label("Votre mot de passe (confirmation)");
	
	$form_signup->add('Email','email_addr')
				->label("Votre adresse email");
				
	$form_signup->add('Submit','submit')
				->value("Valider");
				
	$form_signup->bound($_POST);
?>

<?php
	//Creation of an array for errors
	$error_signup = array();
	
	if($form_signup->is_valid($_POST)) {
		
		//Same password ?
		if($form_signup->get_cleaned_data('password') != $form_signup->get_cleaned_data('password_verif') ) {
			$error_signup[]="Les deux mots de passe entrés ne sont pas identiques";
		}
		
		//No more errors
		if(empty($error_signup)) {
			
			//From PHP doc.
			$hash_validation=md5(uniqid(rand(),true));
			
			//Try to add a new user in the db
			list($username,$password,$email_addr) = $form_signup->get_cleaned_data('username','password','email_addr');
			
			// On veut utiliser le modele de l'signup (~/modeles/signup.php)
			include PATH_MODEL.'signup.php';
			
			//fct add_member_in_db is defined in model/signup.php
			$id_user = add_member_in_db($username, sha1($password),$email_addr,$hash_validation);
			
			// Si la base de données a bien voulu ajouter l'utilisateur (pas de doublons)
			if (ctype_digit($id_user)) {
			
				// On transforme la chaine en entier
				$id_user = (int) $id_user;
				
				
				
				// Preparation du mail
				$message_mail = '<html><head></head><body>
				<p>Merci de vous être inscrit sur "mon site" !</p>
				<p>Veuillez cliquer sur <a href="http://'.$_SERVER['PHP_SELF'].'?module=members&amp;action=valid_account&amp;hash='.$hash_validation.'">ce lien</a> pour activer votre compte !</p>
				</body></html>';
				
				$headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
				$headers_mail .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
				$headers_mail .= 'From: "Mon site" <contact@monsite.com>'      ."\r\n";
				
				// Envoi du mail
				include './modules/mail/mail.php';
				//mail($form_signup->get_cleaned_data('email_addr'), 'signup sur <monsite.com>', $message_mail, $headers_mail);
				
				// Affichage de la confirmation de l'signup
				
				include PATH_VIEW.'signup_done.php';
			
			// Gestion des doublons
			} else {
			
				// Changement de nom de variable (plus lisible)
				$error =& $id_user;
				
				// On vérifie que l'erreur concerne bien un doublon
				if (23000 == $error[0]) { // Le code d'erreur 23000 siginife "doublon" dans le standard ANSI SQL
					preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_problem);
					$value_problem = $value_problem[1];
					
					if ($username == $value_problem) {
					
						$error_signup[] = "Ce nom d'utilisateur est déjà utilisé.";
					
					} else if ($email_addr == $value_problem) {
					
						$error_signup[] = "Cette adresse e-mail est déjà utilisée.";
					
					} else {
					
						$error_signup[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
					}
				
				} else {
				
					$error_signup[] = sprintf("Erreur ajout SQL : cas non traité (SQLSTATE = %d).", $error[0]);
				}
				
				// Display form signup
				include PATH_VIEW.'form_signup.php';
			}
				
		}else{
			//Display again the form
			include PATH_VIEW.'form_signup.php';
		}
		
	}else{
		//Display again the form
		include PATH_VIEW.'form_signup.php';
	}
?>

<?php }//end user_connected verification 
?>