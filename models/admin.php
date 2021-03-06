<?php
	//Add a category
	function add_category($cat_name,$cat_desc,$cat_img){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("INSERT INTO tbl_category SET cat_name = :cat_name, cat_description = :cat_desc, cat_image = :cat_img");
		
		$query->bindValue(":cat_name",htmlspecialchars($cat_name));
		$query->bindValue(":cat_desc",htmlspecialchars($cat_desc));
		$query->bindValue(":cat_img",htmlspecialchars($cat_img));
		
		if($query->execute()) {
			return $pdo->lastInsertId();
			}
		return $query->errorInfo();
		
		}
		
	//Add a product
	function add_product($product_name, $product_cat, $product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("INSERT INTO tbl_products SET cat_id = :category_id, product_name = :product_name, product_description = :product_desc, product_quantity = :product_qty, product_price = :product_price, product_image = :product_img, prdct_health_point = :product_health_pt, prdct_angry_point = :product_angry_pt, prdct_thirst_point = :product_thirst_pt, product_portion = :product_portion");
		
		$query->bindValue(":product_name",$product_name);
		$query->bindValue(":category_id",find_cat_id($product_cat));
		$query->bindValue(":product_desc",$product_desc);
		$query->bindValue(":product_qty",$product_qty);
		$query->bindValue(":product_price",$product_price);
		$query->bindValue(":product_img",$product_img);
		$query->bindValue(":product_health_pt",$product_health_pt);
		$query->bindValue(":product_angry_pt",$product_angry_pt);
		$query->bindValue(":product_thirst_pt",$product_thirst_pt);
		$query->bindValue(":product_portion",$product_portion);
		
		if($query->execute()) {
			return $pdo->lastInsertId();
			}
		return $query->errorInfo();
		
		}
	
	//Update a product
	function update_product($product_name, $product_cat, $product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt,$product_id){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_products SET cat_id = :category_id, product_name = :product_name, product_description = :product_desc, product_quantity = :product_qty, product_price = :product_price, product_image = :product_img, prdct_health_point = :product_health_pt, prdct_angry_point = :product_angry_pt, prdct_thirst_point = :product_thirst_pt, product_portion = :product_portion WHERE product_id = :id_product");
		
		$query->bindValue(":id_product",$product_id);
		$query->bindValue(":product_name",$product_name);
		$query->bindValue(":category_id",find_cat_id($product_cat));
		$query->bindValue(":product_desc",$product_desc);
		$query->bindValue(":product_qty",$product_qty);
		$query->bindValue(":product_price",$product_price);
		$query->bindValue(":product_img",$product_img);
		$query->bindValue(":product_health_pt",$product_health_pt);
		$query->bindValue(":product_angry_pt",$product_angry_pt);
		$query->bindValue(":product_thirst_pt",$product_thirst_pt);
		$query->bindValue(":product_portion",$product_portion);
		
		if($query->execute()) {
			return $pdo->lastInsertId();
			}
		return $query->errorInfo();
		
		}
	
	//Load all the categories
	function load_cat()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT cat_name FROM tbl_category ORDER BY id_category ASC ",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->execute();
		$i=-1;
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$i = $i+1;
   			$tbx['name'][$i]= $row[0];
			
		} 
		
		//echo 'indice '.$tbx[1]['id'];
		return $tbx['name'];
	}
	
	//Get cat_name of a product depending on cat_id
	function cat_name($id_cat)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT cat_name FROM tbl_category WHERE id_category = :id_cat");
		
		$query->bindValue(":id_cat",$id_cat);
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['cat_name'];
		}
		return false;
	}
	
	//Find id of the cat
	function find_cat_id($cat_name){
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT id_category FROM tbl_category WHERE cat_name = :cat_name ");
		
		$query->bindValue(":cat_name",$cat_name);
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['id_category'];
		}
		return false;
	}
	
	//Create an array with all the product_id available
	function all_products_id()
	{
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT product_id FROM tbl_products ORDER BY product_quantity ASC");
		
		$query->execute();
		
		$error = $pdo->errorCode();
		
		if ($result = $query->fetchAll(PDO::FETCH_COLUMN)); {
				$query->closeCursor();
				return $result;
		}
		return false;
	}
	
	//Read infos of all the product and place it in an array
	function infos_product_admin($prdct_id){
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT * FROM tbl_products WHERE product_id = :id_product",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		$query->bindValue(":id_product",$prdct_id);
		
		$query->execute();
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$tbx['product_id']= $row[0];
			$tbx['product_cat_id']=$row[1];
   			$tbx['product_name']= $row[2];
   			$tbx['product_description']= $row[3];
			$tbx['product_quantity']= $row[4];
			$tbx['product_price']= $row[5];
			$tbx['product_image']= $row[6];
			$tbx['prdct_health_pt']= $row[7];
			$tbx['prdct_angry_pt']= $row[8];
			$tbx['prdct_thirst_pt']= $row[9];
			$tbx['product_portion']= $row[10];
		} 
		
		//$tbx is an array with all the informations of a product
		return $tbx;

		}
		
	//Add quantity to a stock
	function add_quantity($product_id,$quantity)
	{
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("UPDATE tbl_products SET product_quantity = IF( (product_quantity + :new_quantity )<0,0,(product_quantity + :new_quantity )) WHERE product_id = :id_product");
		
		$query->bindValue("id_product",$product_id);
		$query->bindValue(":new_quantity",$quantity);
		
		if($query->execute()) {
			return $pdo->lastInsertId();
		}
		print_r($query->errorInfo());
		return $query->errorInfo();
	}
	
	//List all users
	function list_all_users()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT * FROM tbl_user",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->execute();
		$i=-1;
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$i = $i+1;
			$tbx[$i]['user_id']= $row[0];
   			$tbx[$i]['user_pseudo']= $row[1];
   			$tbx[$i]['user_mail']= $row[3];
			$tbx[$i]['user_balance']= $row[4];
			$tbx[$i]['user_lastconnect']= $row[5];
			$tbx[$i]['hash_validation']= $row[6];
		}
		return $tbx;
	}
	
	//Update all the infos of an user
	function update_infos_user($pseudo, $password, $mail, $balance, $id_user)
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("UPDATE tbl_user SET user_pseudo = :pseudo, user_pass = :password, user_mail = :mail, user_balance = :balance WHERE user_id = :id_user");
		
		$query->bindValue(":pseudo",$pseudo);
		$query->bindValue(":password",$password);
		$query->bindValue(":mail",$mail);
		$query->bindValue(":balance",$balance);
		$query->bindValue(":id_user",$id_user);
		
		if($query->execute()) {
			return $pdo->lastInsertId();
		}
		//print_r($query->errorInfo());
		return $query->errorInfo();
	}
	
	//Delete an user depending on his id
	function delete_user($id_user)
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("DELETE FROM tbl_user WHERE user_id = :id_user");
		
		$query->bindValue(":id_user",$id_user);
		if($query->execute()) {
			return $pdo->lastInsertId();
		}
		return $query->errorInfo();
	}
	
	//List all the email adresse of all the users
	function list_all_email()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT user_mail FROM tbl_user ORDER BY user_mail DESC",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->execute();
		$email_addrs="";
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
   			$email_addrs = $row[0].'; '.$email_addrs;
			
		}
		return $email_addrs;
	}
	
	//List all rabbits
	function list_all_rabbits()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT * FROM tbl_rabbit",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->execute();
		$i=0;
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$tbx[$i]['rabbit_id']= $row[0];
   			$tbx[$i]['rabbit_usr_id']= $row[1];
   			$tbx[$i]['rabbit_token']= $row[2];
			$tbx[$i]['rabbit_serial']= $row[3];
			$tbx[$i]['rabbit_name']= $row[4];
			$i = $i+1;
		}
		
		$query = $pdo->prepare("SELECT * FROM tbl_rabbit_skill",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->execute();
		$i=0;
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$tbx[$i]['rabbit_skill_id']= $row[0];
   			$tbx[$i]['skill_angry']= $row[2];
   			$tbx[$i]['skill_thirst']= $row[3];
			$tbx[$i]['skill_health']= $row[4];
			$i = $i+1;
		}
		
		return $tbx;
	}
	
	//Treat nabz function all points at 100%
	function treat_nabz($id_nabz)
	{
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = :full_skill, skill_thirst = :full_skill, skill_health = :full_skill WHERE rabbit_id = :id_nabz");
		
		$query->bindValue(':full_skill',100);
		$query->bindValue(':id_nabz',$id_nabz);
		$query->execute();
		
		return $query->errorInfo();
	}
	
	//Update nabz skill
	function update_nabz_skill($id_nabz, $skill_angry,$skill_thirst,$skill_health)
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = IF( (:skill_angry)>100,100,(:skill_angry)) ,skill_thirst = IF( (:skill_thirst)>100,100,(:skill_thirst)),skill_health = IF( (:skill_health)>100,100,(:skill_health)) WHERE rabbit_id = :id_nabz");
		
		$query->bindValue(':skill_angry',$skill_angry);
		$query->bindValue(':skill_thirst',$skill_thirst);
		$query->bindValue(':skill_health',$skill_health);
		$query->bindValue(':id_nabz',$id_nabz);
		
		$query->execute();
		
		return $query->errorInfo();
	
	}
	
	//Number of tickets sold for the bingo
	function num_ticket_sold()
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("SELECT COUNT( * ) AS usr_id FROM tbl_numbers WHERE usr_id >0");
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['usr_id'];
		}
		return $query->errorInfo();
		
	}
	
	//Function to update the new price of ticket
	function update_bingo_price($new_price)
	{
		//read info about the bingo
		$bingo_info = fopen('global/bingo.txt','r+');
		//price of a ticket is on the first line
		$char_price = fgets($bingo_info);
		
		$char_price = str_replace("price:","",$char_price);
		
		//new pointer will be before the value of the price, ftell calls the current position of the cursor
		$pointer = ftell($bingo_info)-strlen($char_price);
		//Move the cursor to the new pointer
		fseek($bingo_info,$pointer);
		//Write the new price
		$new_price = $new_price."\n";
		fputs($bingo_info,$new_price);
		fclose($bingo_info);

	}
	
	//Function to update the jackpot of the bingo
	function update_bingo_jackpot($new_jackpot)
	{
		//read info about the bingo
		$bingo_info = fopen('global/bingo.txt','r+');
		//price of a ticket is on the first line
		$price = fgets($bingo_info);
		
		//total jackpot is on the second
		$char_jackpot = fgets($bingo_info);
		$char_jackpot = str_replace("jackpot:","",$char_jackpot);
		
		//new pointer will be before the value of the jackpot, ftell calls the current position of the cursor
		$pointer = ftell($bingo_info)-strlen($char_jackpot);
		
		//Move the cursor to the new pointer
		fseek($bingo_info,$pointer);
		
		//Write the new jackpot
		$new_jackpot = $new_jackpot."\n";
		fputs($bingo_info,$new_jackpot);
		fputs($bingo_info," ");
		fclose($bingo_info);
	}
	
	//Function to dertermine who wins the bingo
	function bingo_find_winner($jackpot,$nb_gamers)
	{
		$pdo = PDO2::getInstance();
		
		//Who played?
		$query = $pdo->prepare("SELECT usr_id FROM tbl_numbers WHERE usr_id >0");
		$query->execute();
		
		$i=0;
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$tbx_gamers[$i]= $row[0];
			$i = $i+1;
		}
		
		$number = mt_rand(0,$nb_gamers-1);
		
		$id_winner = $tbx_gamers[$number];
		
		//Add the jackpot
		$query = $pdo->prepare("UPDATE tbl_user SET user_balance = user_balance + :jackpot WHERE user_id = :id_winner");
		$query->bindValue(":jackpot",$jackpot);
		$query->bindValue(":id_winner",$id_winner);
		$query->execute();
		
		return $id_winner;
		
	}
	
	//Function return the name depending on id
	function get_name_user($id_user)
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("SELECT user_pseudo FROM tbl_user WHERE user_id = :id_user");
		$query->bindValue(":id_user",$id_user);
		$query->execute();
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['user_pseudo'];
		}
		return $query->errorInfo();
	}
	
	//Function to insert the winner in the textfile
	function update_winners($id_winner)
	{
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
		
		//Do the permutation
		$i=4;
		$array_winners[4]="";
		while($i>0)
		{
		    $array_winners[$i]=$array_winners[$i-1];
		    $i=$i-1;
		}
		
		$array_winners[0] = get_name_user($id_winner)."\n";
		
		//Write in file
		$bingo_winners = fopen('global/bingo_winners.txt','r+');
		
		foreach($array_winners as $value)
		{
		    fputs($bingo_winners,$value);
		}
		fclose($bingo_winners);
	}
	
	//Function to init the table of bingo
	function init_bingo()
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("UPDATE tbl_numbers SET usr_id = 0 WHERE usr_id >0");
		$query->execute();
		
		//Init jackpot on the txt_file
		update_bingo_jackpot(0);
	}
?>