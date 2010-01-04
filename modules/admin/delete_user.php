<?php
    if(!user_admin())
    {
	    include PATH_GLOBAL_VIEW.'error_not_admin.php';
    }
    else
    {
            require_once(PATH_MODEL.'admin.php');
            delete_user($_GET['uid']);
            header("Location: index.php?module=admin&action=users&id=".$_SESSION['id']); //reload Admin user page
    }//end of user_admin
?>