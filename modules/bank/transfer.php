<?php
    if(!user_connected())
    {
        include PATH_GLOBAL_VIEW.'error_not_connected.php';
    }else{
        
        include PATH_VIEW.'view_transfert.php';
    }

?>