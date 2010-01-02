<?php

	//Read infos of a product depending on cat_id
	function read_infos_product($cat_id){
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT * FROM tbl_products WHERE cat_id = :id_cat  AND product_quantity >0", array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		
		$query->bindValue(":id_cat",$cat_id);
		
		$query->execute();
		$i=-1;
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$i = $i+1;
			$tbx['product_id'][$i]= $row[0];
   			$tbx['product_name'][$i]= $row[2];
   			$tbx['product_description'][$i]= $row[3];
			$tbx['product_quantity'][$i]= $row[4];
			$tbx['product_price'][$i]= $row[5];
			$tbx['product_image'][$i]= $row[6];
			$tbx['prdct_health_pt'][$i]= $row[7];
			$tbx['prdct_angry_pt'][$i]= $row[8];
			$tbx['prdct_thirst_pt'][$i]= $row[9];
			$tbx['product_portion'][$i]= $row[10];
		} 
		
		//$tbx is an array with all the informations of all the product in the cat
		return $tbx;
		
		}
		
	//Number of product in a cat
	function number_product_cat($cat_id){
		
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT COUNT(*) AS nbr FROM tbl_products WHERE cat_id =:id_cat AND product_quantity >0");
	
		$query->bindValue(":id_cat",$cat_id);
	
		$query->execute();
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['nbr'];
		}
		return false;
		}
	
	//Read infos of all the product and place it in an array
	function infos_product($prdct_id){
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT * FROM tbl_products WHERE product_id = :id_product AND product_quantity >0",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
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
		
	//Get the name of a cat
	function cat_name($id_category)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT cat_name FROM tbl_category WHERE id_category = :cat_id");
		
		$query->bindValue(":cat_id",$id_category);
		
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		
			$query->closeCursor();
			return $result['cat_name'];
		}
		return false;
	}
	
	//Get the number of category
	function number_category()
	{
		$pdo = PDO2::getInstance();
		
		$query=$pdo->prepare("SELECT COUNT(*) AS nbr FROM tbl_category");
	
		$query->execute();
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['nbr'];
		}
		return false;
	}
	
	//Buy a product
	function buy_product($prdct_id,$usr_id)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("INSERT INTO tbl_cart SET user_id = :id_user, product_id = :id_product, cat_id = :id_cat, product_quantity = :product_quantity");
		
		$infos_product_tobuy = infos_product($prdct_id);
		
		$query->bindValue(":id_user",$usr_id);
		$query->bindValue(":id_product",$prdct_id);
		$query->bindValue(":id_cat",$infos_product_tobuy['product_cat_id']);
		$query->bindValue(":product_quantity",$infos_product_tobuy['product_portion']);
		
		$query->execute();
		echo 'catégorié'.$infos_product_tobuy['product_cat_id'];
		//Update the balance of the account
		$query = $pdo->prepare("UPDATE tbl_user SET user_balance = :new_balance WHERE user_id = :id_user");
		$query->bindValue(":new_balance",user_balance($usr_id)-$infos_product_tobuy['product_price']);
		$query->bindValue(":id_user",$usr_id);
		
		$query->execute();
		
		//Soustract a element in the store
		$query = $pdo->prepare("UPDATE tbl_products SET product_quantity = IF( (product_quantity -1)<0,0,(product_quantity - 1)) WHERE product_id = :id_product");
		$query->bindValue(":id_product",$prdct_id);
		
		$query->execute();
		
		
		
	}
	
	//If the product is already in the cart of the user add it on the same line
	function add_product_incart($prdct_id, $usr_id)
	{
		$pdo = PDO2::getInstance();

		//Find initial quantity
		$query = $pdo->prepare("SELECT product_quantity FROM tbl_cart WHERE user_id = :id_user AND product_id = :id_product");

		$query->bindValue(":id_user",$usr_id);
		$query->bindValue(":id_product",$prdct_id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$prdct_qty = $result['product_quantity'];
		
		//Soustract a element in the store
		$query = $pdo->prepare("UPDATE tbl_products SET product_quantity = IF( (product_quantity -1)<0,0,(product_quantity - 1)) WHERE product_id = :id_product");
		$query->bindValue(":id_product",$prdct_id);
		
		$query->execute();
		
		//Add new quantity of product in the cart
		$query = $pdo->prepare("UPDATE tbl_cart SET product_quantity = :new_quantity WHERE user_id = :id_user AND product_id = :id_product");
		
		$infos_product_tobuy = infos_product($prdct_id);
		
		$query->bindValue(":id_user",$usr_id);
		$query->bindValue(":id_product",$prdct_id);
		$query->bindValue(":new_quantity",$infos_product_tobuy['product_portion']+$prdct_qty);
		
		$query->execute();
		
		//Update the balance of the account
		$query = $pdo->prepare("UPDATE tbl_user SET user_balance = :new_balance WHERE user_id = :id_user");
		$query->bindValue(":new_balance",user_balance($usr_id)-$infos_product_tobuy['product_price']);
		$query->bindValue(":id_user",$usr_id);
		$query->execute();
	}
	
	//Get number of portion of a product
	function nbr_portion_prdct($prdct_id)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT product_portion FROM tbl_products WHERE product_id = :id_product");
		
		$query->bindValue(":id_product",$prdct_id);
		
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		
			$query->closeCursor();
			return $result['product_portion'];
		}
		return false;
	}
	
	//Is there already this product is his cart ?
	function uniq_prdct_in_cart($prdct_id, $usr_id)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT cart_id FROM tbl_cart WHERE user_id = :id_user AND product_id = :id_product");
		
		$query->bindValue(":id_user",$usr_id);
		$query->bindValue(":id_product",$prdct_id);
		
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$query->closeCursor();
			return $result['cart_id'];
		}
		return false;
	}
	
	//Use the product on the rabbit
	/*function use_product($id_product,$id_nabz)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = skill_angry + :skill_angry, skill_thirst = skill_thirst + :skill_thirst, skill_health = skill_health + :skill_health WHERE rabbit_id = :id_nabz");
		$infos_product = infos_product($id_product);
		$pt_angry = $infos_product['prdct_angry_pt'];
		$pt_thirst = $infos_product['prdct_thirst_pt'];
		$pt_health = $infos_product['prdct_health_pt'];
		
		$query->bindValue(':skill_angry',$pt_angry);
		$query->bindValue(':skill_thirst',$pt_thirst);
		$query->bindValue(':skill_health',$pt_health);
		$query->bindValue(':id_nabz',$id_nabz);
		
		$query->execute();
		
		$skill_nabz = read_skill_nabz($id_nabz);
		$pt_nabz_angry = $skill_nabz['skill_angry'];
		$pt_nabz_thirst = $skill_nabz['skill_thirst'];
		$pt_nabz_health = $skill_nabz['skill_health'];
		
		if($pt_nabz_angry > 100){
			$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = :skill_angry WHERE rabbit_id = :id_nabz");
			$query->bindValue(':skill_angry',100);
			$query->execute();
		}else if($pt_nabz_thirst > 100){
			$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_thirst = :skill_thirst WHERE rabbit_id = :id_nabz");
			$query->bindValue(':skill_thirst',100);
			$query->execute();
		}else if($pt_nabz_health >100){
			
			$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_health = :skill_health WHERE rabbit_id = :id_nabz");
			$query->bindValue(':skill_health',100);
			$query->execute();
		}
		
		return($query->rowCount() == 1);
	}*/
?>