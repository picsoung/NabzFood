<?php
    if(!user_connected()) //only display the page if user is not connected
    {
        include PATH_LIB.'form.php';
        
        $form_reset_pwd = new Form('form_reset_pwd');
        $form_reset_pwd->method('POST');
        
        $form_reset_pwd->add('Text','email_adress')
                        ->label('Votre adresse e-mail');
        $form_reset_pwd->add('Submit','submit')
                        ->value('Envoyer informations');
                        
        //errors and message arrays
        $error_reset_pwd = array();
        $msg_confirm = array();
        
        //operations on the reset form
        if($form_reset_pwd->is_valid($_POST))
        {
            $email_addr = $form_reset_pwd->get_cleaned_data('email_adress');
            
            $user_id = find_user_id($email_addr);
	    
            if ($user_id !== false)
            {
                $new_pwd = gen_new_pwd(); //generate a new password
                
                update_password_user($user_id,$new_pwd); //update the modification
                $msg_confirm[]="Mot de passe réinitialisé avec succès, vous recevrez prochainement un mél avec vos différentes informations de connexion. Attention pensez à changer le nouveau mot de passe pour le retenir plus facilement.";
                
                $infos_user = read_infos_user($user_id);
            
            // Preparation du mail
            $message_mail = "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"> </head><body> <p>Nouveau mot de passe <b>NabzFood</b>.</p> <p>Vous avez demandé à changer votre mot de passe pour le site Nabzfood, ce mél est la confirmation que tout s'est bien passé.</p><p>Vos nouvelles informations de connexion : </p><p>Login : ".$infos_user['user_pseudo']."</p><p>Mot de passe : ".$new_pwd."</p>";
	    
	    if(!empty($infos_user['hash_validation'])) //only to resend an activation link for whose who dont
	    {
		print_r($infos_user);
		$hash_validation=$infos_user['hash_validation'];
		$message_mail.= "<p>Lien pour valider votre compte : <a href=\"http:\//".$_SERVER['PHP_SELF']."?module=members&amp;action=valid_account&amp;hash=".$hash_validation."\">ce lien</a> pour activer votre compte !</p>";
		
	    }//end of empty hash_validation
	    $message_mail .="</body></html>";
		
		$subject = "[Nabzfood] Réinitialisation mot de passe";
	    // Envoi du mail
	    include './modules/mail/mail.php';
        
	    }else
	    {
                $error_reset_pwd[]="Nous n'avons pas trouvé de compte corespondant à cet e-mail, merci d'enter une adresse valide. Si vous n'êtes pas encore inscrit cliquez sur le lien \"Inscription\" dans le menu de gauche.";
            }//end of user_id !=false

        }//end is valid
        include PATH_VIEW.'form_reset_pwd.php';
    }else
    {
        PATH_GLOBAL_VIEW.'error_already_connected.php';
    }//end user_connected
?>