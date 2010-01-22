<?php
    if(!user_connected())
    {
        include PATH_GLOBAL_VIEW.'error_not_connected.php';
    }else{
        
        include PATH_MODEL.'bank.php';
        $id_user=$_SESSION['id'];
        
        //read info about the bingo
        $bingo_info = fopen('global/bingo.txt','r+');
        //price of a ticket is on the first line
        $price = fgets($bingo_info);
        $price = (int)str_replace("price:","",$price);
        //total jackpot is on the second
        $jackpot = fgets($bingo_info);
        $jackpot = (int)str_replace("jackpot:","",$jackpot);
        fclose($bingo_info);
        
        //last 5 winners are in the last 5lines of the file
        $bingo_winners = fopen('global/bingo_winners.txt','r+');
        $array_winners = array();
        $i=0;
        while($i<5)
        {
            array_push($array_winners,str_replace(CHR(13).CHR(10),"",fgets($bingo_winners))); //without breaklines
            $i++;
        }
        fclose($bingo_winners);
        
        //Display error if the balance of the user is not enough to buy a ticket
        if(user_balance($id_user)<$price)
        {
            $error_bingo[]="Vous ne disposez pas d'assez de nab\$z pour acheter un ticket.";
        }
      
        $tbx = list_all_numbers();
        
        include PATH_VIEW.'view_bingo.php';
    }

?>