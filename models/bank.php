<?php
    //Function to list all the numbers of the grid
    function list_all_numbers()
    {
        $pdo = PDO2::getInstance();
        
        $query = $pdo->prepare("SELECT * FROM tbl_numbers");
        $query->execute();
        
        $tbx=array();
        $i=0;
        while ($row = $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
        {
                $tbx[$i]['number']=$row[0];
                $tbx[$i]['usr_id']=$row[1];
                $i=$i+1;
        }
        return $tbx;
    }
   
    //Function to buy a bingo ticket
    function buy_ticket($id_user,$number,$ticket_price)
    {
        $pdo = PDO2::getInstance();
        
        //Change usr_id column in number row in the table tbl_numbers
        $query = $pdo->prepare("UPDATE tbl_numbers SET usr_id = :usr_id WHERE id = :number");
        $query->bindValue(":usr_id",$id_user);
        $query->bindValue(":number",$number);
        $query->execute();
        print_r($query->errorInfo());
        
        //Update the balance of the account
	$query = $pdo->prepare("UPDATE tbl_user SET user_balance = :new_balance WHERE user_id = :id_user");
	$query->bindValue(":new_balance",user_balance($id_user)-$ticket_price);
        $query->bindValue(":id_user",$id_user);
        $query->execute();
        print_r($query->errorInfo());
        
        update_jackpot();
    }
    
    //Function to update the jackpot on the textfile
    function update_jackpot()
    {
        //read info about the bingo
        $bingo_info = fopen('global/bingo.txt','r+');
        //price of a ticket is on the first line
        $price = fgets($bingo_info);
        $price = (int)str_replace("price:","",$price);
        
        //total jackpot is on the second
        $char_jackpot = fgets($bingo_info);
        $char_jackpot = str_replace("jackpot:","",$char_jackpot);
        $jackpot = (int)$char_jackpot;
        
        $new_jackpot = $jackpot + $price;
        
        //new pointer will be before the value of the jackpot, ftell calls the current position of the cursor
        $pointer = ftell($bingo_info)-strlen($char_jackpot);
        //Move the cursor to the new pointer
        fseek($bingo_info,$pointer);
        //Write the new jackpot
        fputs($bingo_info,$new_jackpot);
    }
?>
