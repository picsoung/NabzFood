<?php
    if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id']))
    {
        include PATH_GLOBAL_VIEW.'error_not_connected.php';
    }else{
        include_once(PATH_MODEL.'members.php');
        include PATH_MODEL.'bank.php';
        
        $id_user = $_SESSION['id'];
        $number = $_GET['number'];
        
        buy_ticket($id_user,$number);
        
        header("Location: index.php?module=bank&action=bingo&id=".$_SESSION['id']);
    }

?>