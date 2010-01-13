<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		require_once(PATH_MODEL.'admin.php');
		require_once(PATH_MODEL.'nabz.php');
		require_once(PATH_LIB."nabz_lib.php");
		require_once(PATH_LIB."form.php");
		
		$form_mail_nabz = new Form('form_mail_nabz');
                $form_mail_nabz->method('POST');
                $form_mail_nabz->add('Textarea','mail_content')
                                ->label('Message')
                                ->cols(100)
                                ->rows(20);
				
		$form_mail_nabz->add('Select','lang_select')
				->label('Langue')
				->choices('Français','Anglais');
                $form_mail_nabz->add('Submit','Envoyer');
                    
                if($form_mail_nabz->is_valid($_POST))
                {
                    
                    $message = $_POST['mail_content']; //dont use get_cleaned because it loose the aspect of the txt
                    
		    //Messages in different languages
		    $lang = $form_mail_nabz->get_cleaned_data('lang_select');
		    if($lang != 'Français')
		    {
			$lang ="us";
		    }else {
			$lang = "fr";
			}
                        
                    $tbx = list_all_rabbits();
                    foreach($tbx as $key => $value)
                    {
                        $nabz_serial = $tbx[$key]['rabbit_serial'];
                        $nabz_token = $tbx[$key]['rabbit_token'];
                        //Send message with lib+API
                        $nabaztag = new Nabaztag($nabz_serial,$nabz_token,$lang);
                        $nabaztag->dire($message);
                        $nabaztag->send();
                    }
		    
		    
                }//end of is_valid
		
		include PATH_VIEW.'form_mail_all_nabz.php';
	}//end of user_admin

?>