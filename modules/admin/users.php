<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		include PATH_LIB.'form.php';
		require_once(PATH_MODEL.'admin.php');
		
		$tbx = list_all_users();
		//print_r($tbx);
		
		$form_user = new Form('form_user');
		$form_user->method('POST');
		;
		
		include PATH_VIEW.'view_users.php';
	}//end of user_admin

?>