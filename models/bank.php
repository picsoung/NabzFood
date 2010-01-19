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
    function buy_ticket($id_user,$number)
    {
        $ticket_price = 5;
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
    }
?>
