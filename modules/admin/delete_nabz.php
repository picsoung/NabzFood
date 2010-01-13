<?php
    if(!user_admin())
    {
	    include PATH_GLOBAL_VIEW.'error_not_admin.php';
    }
    else
    {
            require_once(PATH_MODEL.'nabz.php');
            delete_nabz($_GET['nabz_id']);
            header("Location: index.php?module=admin&action=nabz&id=".$_SESSION['id']); //reload Admin user page
    }//end of user_admin
?>