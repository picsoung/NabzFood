<?php
	if(!user_admin()){
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else
	{
		include PATH_LIB.'form.php';
		require_once(PATH_MODEL.'admin.php');
		require_once(PATH_MODEL.'members.php'); //include the two models to not rewrite functions that already exist
		require_once(PATH_MODEL.'nabz.php');
		
		$id_user = $_GET['uid'];
		$infos_user = read_infos_user($id_user);
		$user_balance = user_balance($id_user);
		
		$infos_nabz = read_infos_nabz($id_user);
		
		$form_edit_user = new Form('form_edit_user');
		$form_edit_user->method('POST');
		$form_edit_user->add('Text','login')
						->label('Login')
						->value($infos_user['user_pseudo']);
		$form_edit_user->add('Text','password')
						->label('Mot de passe')
						->value($infos_user['user_pass']);
		$form_edit_user->add('Text','email_addr')
						->label('Email')
						->value($infos_user['user_mail']);
		$form_edit_user->add('Text','balance')
						->label('Solde')
						->value($user_balance);
		
		if(empty($infos_user['hash_validation']))
		{
			$valid_opt=0;
		}
		else
		{
			$valid_opt=1;
		}
		
		$form_edit_user->add('Checkbox','valid_account')
				->label('Compte validé')
				->value($valid_opt)
				->required('false');
						
		/*Nabz Infos Part*/
		//modify an existing nabz or add it to an account user			
		if($infos_nabz !== false) { //Load infos about the nabz associated to this user account
				$nabz_serial = $infos_nabz['rabbit_serial'];
				$nabz_token = $infos_nabz['rabbit_token'];
				$nabz_name = $infos_nabz['rabbit_name'];
				$id_nabz = $infos_nabz['rabbit_id'];
				$required = "true";
		}else{
			$required = "false";
			$nabz_serial = "";
			$nabz_token = "";
		}
		$form_edit_user->add('Text','nabz_serial')
						->label('Serial du Nabz')
						->required($required)
						->value($nabz_serial);
		$form_edit_user->add('Text','nabz_token')
						->label('Token du Nabz')
						->required($required)
						->value($nabz_token);
				
		$form_edit_user->add('Submit','submit')
						->value('Éditer');
		
		
		if($form_edit_user->is_valid($_POST))
		{
			list($new_login,$new_pass,$new_email,$new_balance, $valid_account, $new_nabz_serial, $new_nabz_token) = $form_edit_user->get_cleaned_data('login','password','email_addr','balance','valid_account','nabz_serial','nabz_token');
			
			if($new_pass != $infos_user['user_pass']) //modify user password
			{
				$new_pass = sha1($new_pass);
			}else { $new_pass = $infos_user['user_pass'];}
			
			if(nabz_exists($new_nabz_serial,$new_nabz_token)==true)
			{
				 update_infos_nabz($id_user,$new_nabz_serial,$new_nabz_token);
			}
			else
			{
				$error_update[] ="Couple token/serial incorrect.";
			}
			//end nabz_exist
			
				$update = update_infos_user($new_login, $new_pass, $new_email, $new_balance, $id_user);
			
				if($update[0]==23000)
				{
					$error=ereg_replace("for key 3","",$update[2]);
					$error_update[]=$error;
				}else
				{
					$msg_confirm[] = "Modification effectuée";
				}//end $update
			
				if(!empty($valid_account)) //valid user account if checkbox checked
				{
					valid_account($infos_user['hash_validation']);
				}
			//header("Location: index.php?module=admin&action=users&id=".$_SESSION['id']); //Reload page
			
			
		}//end of form is_valid
		
		include PATH_VIEW.'form_edit_users.php';
	}
?>