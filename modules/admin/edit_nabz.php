<?php
	if(!user_admin()){
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else
	{
		include PATH_LIB.'form.php';
		require_once(PATH_MODEL.'admin.php');
		require_once(PATH_MODEL.'members.php'); //include the two models to not rewrite functions that already exist
		require_once(PATH_MODEL.'nabz.php');
		
		$id_nabz = $_GET['nabz_id'];
                $id_user = $_GET['uid'];
		$user_balance = user_balance($id_user);
		
		$infos_nabz = read_infos_nabz($id_user);
                $infos_nabz_skill = read_skill_nabz($id_nabz);
		
		$form_edit_nabz = new Form('form_edit_nabz');
		$form_edit_nabz->method('POST');
		$form_edit_nabz->add('Text','serial')
						->label('Serial')
						->value($infos_nabz['rabbit_serial']);
		$form_edit_nabz->add('Text','token')
						->label('Token')
						->value($infos_nabz['rabbit_token']);
		$form_edit_nabz->add('Text','name')
						->label('Nom')
						->value($infos_nabz['rabbit_name']);
		$form_edit_nabz->add('Text','skill_angry')
						->label('Faim')
						->value($infos_nabz_skill['skill_angry']);
                $form_edit_nabz->add('Text','skill_thirst')
						->label('Soif')
						->value($infos_nabz_skill['skill_thirst']);
                $form_edit_nabz->add('Text','skill_health')
						->label('Santé')
						->value($infos_nabz_skill['skill_health']);
	
				
		$form_edit_nabz->add('Submit','submit')
						->value('Éditer');
		
		
		if($form_edit_nabz->is_valid($_POST))
		{
			list($new_nabz_serial, $new_nabz_token, $new_nabz_name, $new_skill_angry, $new_skill_thirst, $new_skill_health) = $form_edit_nabz->get_cleaned_data('serial','token','rabbit_name','skill_angry','skill_thirst','skill_health');
			
			if(nabz_exists($new_nabz_serial,$new_nabz_token)==true)
			{
				 update_infos_nabz($id_user,$new_nabz_serial,$new_nabz_token);
			}
			else
			{
				$error_update[] ="Couple token/serial incorrect.";
			}
			//end nabz_exist
                            if($new_skill_angry == $infos_nabz_skill['skill_angry'])
                            {
                                $new_skill_angry = $infos_nabz_skill['skill_angry'];
                            }
                            
                            if($new_skill_thirst == $infos_nabz_skill['skill_thirst'])
                            {
                                $new_skill_thirst = $infos_nabz_skill['skill_thirst'];
                            }
                            
                            if($new_skill_thirst == $infos_nabz_skill['skill_health'])
                            {
                                $new_skill_thirst = $infos_nabz_skill['skill_health'];
			    }
                        
				$update = update_nabz_skill($id_nabz,$new_skill_angry,$new_skill_thirst,$new_skill_health);
	
				$msg_confirm[] = "Modification effectuée";
			header("Location: index.php?module=admin&action=edit_nabz&nabz_id=".$id_nabz."&uid=".$_GET['uid']); //Reload page
			
			
		}//end of form is_valid
		
		include PATH_VIEW.'form_edit_nabz.php';
	}
?>