<?php
    if(!user_admin())
    {
	    include PATH_GLOBAL_VIEW.'error_not_admin.php';
    }
    else
    {
            require_once(PATH_MODEL.'admin.php');
            require_once(PATH_MODEL.'members.php');
            require_once(PATH_LIB.'form.php');
            
            $form_mail_user = new Form('form_mail_user');
            $form_mail_user->method('POST');
            
            $form_mail_user->add('Text','mail_subject')
                            ->label('Sujet du message')
                            ->value('[Nabzfood]');
            $form_mail_user->add('Textarea','mail_content')
                            ->label('Message')
                            ->cols(100)
                            ->rows(20);
            $form_mail_user->add('Submit','Envoyer');
                            
            $infos_user = read_infos_user($_GET['uid']);
            $pseudo = $infos_user['user_pseudo'];
            
	    if($form_mail_user->is_valid($_POST))
	    {
		$subject = $form_mail_user->get_cleaned_data('mail_subject');
		$txtmessage =$_POST['mail_content']; //dont use get_cleaned because it loose the aspect of the txt
		
		$txtmessage = str_replace("\r\n", "<br \>", $txtmessage);  //replace txt \n by HTML <br />
		
		$email_addr = $infos_user['user_mail'];
		$message_mail = $txtmessage;

		//Send mail
		include './modules/mail/mail.php';
	    }//end of is_valid
	    
            include PATH_VIEW.'form_mail_user.php';
            
            
            
            //header("Location: index.php?module=admin&action=users&id=".$_SESSION['id']); //reload Admin user page
    }//end of user_admin
?>