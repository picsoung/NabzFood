<?php
    if(!user_connected())
    {
        include PATH_GLOBAL_VIEW.'error_not_connected.php';
    }else{
        $balance = user_balance($_SESSION['id']);
        
        include PATH_VIEW.'view_bank.php';
    }

?>