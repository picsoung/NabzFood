<?php
    if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id']))
    {
        include PATH_GLOBAL_VIEW.'error_not_connected.php';
    }else{
        include_once(PATH_MODEL.'members.php');
        include PATH_MODEL.'bank.php';
        
        $id_user = $_SESSION['id'];
        $number = $_GET['number'];
        
        //read info about the bingo
        $bingo_info = fopen('global/bingo.txt','r+');
        //price of a ticket is on the first line
        $price = fgets($bingo_info);
        $price = (int)str_replace("price:","",$price);
        
        //Only if the balance is enough
        if($price < user_balance($id_user))
        {
             buy_ticket($id_user,$number,$price);
        }
        
        header("Location: index.php?module=bank&action=bingo&id=".$_SESSION['id']);

    }

?>