<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		require_once(PATH_MODEL.'admin.php');
		
		$tbx = list_all_rabbits();
		
		include PATH_VIEW.'view_rabbits.php';
	}//end of user_admin

?>