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
	
?>