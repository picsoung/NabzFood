<?php
//only display this page if user is not connected
	if(user_connected()) {
		include PATH_GLOBAL_VIEW.'error_already_connected.php';
	}else {?>

<?php
	//Is there an hash on the url ?
	if(!empty($_GET['hash'])):
		
		if(valid_account($_GET['hash'])):
		
			include PATH_VIEW.'account_validated.php';
		else:
			//error in validation
			include PATH_VIEW.'error_account_validation.php';
		endif;
		
	else:
		include PATH_VIEW.'error_account_validation.php';
	endif;
?>

<?php }//end user_connected verification 
?>