<?php

	//Read SN and Token of the nabz
	function read_infos_nabz($id_user){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT rabbit_id, rabbit_token, rabbit_serial, rabbit_name FROM tbl_rabbit WHERE rabbit_usr_id = :id_user");
		
		$query->bindValue(":id_user",$id_user);
		$query->execute();
		
			if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			
				$query->closeCursor();
				return $result;
			}
			return false;
	}
		
	//Read skill infos of the nabz
	function read_skill_nabz($id_nabz){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT skill_angry, skill_thirst, skill_health FROM tbl_rabbit_skill WHERE rabbit_id = :id_nabz");
		
		$query->bindValue(":id_nabz",$id_nabz);
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			
				$query->closeCursor();
				return $result;
			}
			return false;
		
		}	
	
	//Function to add a nabz in db
	function add_nabz_in_db($nabz_serial, $nabz_token,$id_user){
		$pdo = PDO2::getInstance();
		
		$url ='sn='.$nabz_serial.'&token='.$nabz_token;

		$violet_response = file_get_contents(API_URL."api.jsp?".$url."&action=10");
		
		preg_match("/<rabbitName(.*)>(.*)<\/rabbitName>/", $violet_response,$nabz_name);
		
		$query = $pdo->prepare("INSERT INTO tbl_rabbit SET rabbit_token =:token, rabbit_serial =:serial, rabbit_usr_id =:user_id, rabbit_name = :nabz_name");
		
		$query->bindValue(":token",$nabz_token);
		$query->bindValue(":serial",$nabz_serial);
		$query->bindValue(":user_id",$id_user);
		$query->bindValue(":nabz_name",$nabz_name[2]);
		
		
		
		if($query->execute()) {
				return $pdo->lastInsertId();
		}
		return $query->errorInfo();
	}
	
	//Init the skill of the nabz
	function init_nabz_skill($id_nabz){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("INSERT INTO tbl_rabbit_skill SET rabbit_id =:id_rabbit, skill_angry =:angry_start, skill_thirst =:thirst_start, skill_health =:health_start");
		
		$start_point = "100";
		
		$query->bindValue(":id_rabbit",$id_nabz);
		$query->bindValue(":angry_start",$start_point);
		$query->bindValue(":thirst_start",$start_point);
		$query->bindValue(":health_start",$start_point);
		
		
		$error = $pdo->errorCode();
		
		$query->execute();

		return $query->errorInfo();
		}
		
	//Update infos of the nabz
	function update_infos_nabz($id_user,$nabz_serial,$nabz_token) {
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit SET rabbit_serial = :serial, rabbit_token = :token WHERE rabbit_usr_id = :id_user");
		
		$query->bindValue(":serial",$nabz_serial);
		$query->bindValue(":token",$nabz_token);
		$query->bindValue(":id_user",$id_user);
		
		$error = $pdo->errorCode();
		
		return $query->execute();
		}
		
	//Is token-serial valid ?
	function nabz_exists($nabz_serial,$nabz_token){
		
		$url ='sn='.$nabz_serial.'&token='.$nabz_token;

		$violet_response = file_get_contents(API_URL."api.jsp?".$url."&action=10");
		
		preg_match("/<rabbitName>.+<\/rabbitName>/", $violet_response,$nab_name);
		
		if($nab_name != null)
		{
			return true;
		}else{
			return false;
			}
		}
		
	//Delete nabz
	function delete_nabz($id_rabbit){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("DELETE FROM tbl_rabbit WHERE rabbit_id = :rabbit_id;DELETE FROM tbl_rabbit_skill WHERE rabbit_id = :rabbit_id");
		
		$query->bindValue(":rabbit_id",$id_rabbit);
		
		$error = $pdo->errorCode();
		
		return $query->execute();
		}
		
	//Display skill image
	function display_skill_img($skill)
	{
		header("Content-type: image/png"); 
	    $im = ImageCreate (200, 100) or die ("Erreur lors de la création de l'image");         
	    $couleur_fond = ImageColorAllocate ($im, 255, 0, 0); 
	    ImagePng ($im); 
	}
	
	//Display item in the cart depending on cat id
	function display_item_in_cat($id_cat,$usr_id)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT product_id FROM tbl_cart WHERE cat_id = :id_cat AND user_id = :user_id");
		
		$query->bindValue(':id_cat',$id_cat);
		$query->bindValue(':user_id',$usr_id);
		
		$query->execute();
		
		$error = $pdo->errorCode();
		
		if ($result = $query->fetchAll(PDO::FETCH_COLUMN)); {
				$query->closeCursor();
				return $result;
		}
		return false;
		
	}
	
	//Display quantity of a product in the cart
	function display_quantity($id_product,$usr_id)
	{
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT product_quantity FROM tbl_cart WHERE product_id = :id_product AND user_id = :user_id");
		
		$query->bindValue(':id_product',$id_product);
		$query->bindValue(':user_id',$usr_id);
		
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_BOTH)) {
				$query->closeCursor();
				return $result['product_quantity'];
		}
		return false;
	}
	
	//Use the product on the rabbit
	function use_product($id_product,$id_nabz)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = IF( (skill_angry + :skill_angry)>100,100,(skill_angry + :skill_angry)) ,skill_thirst = IF( (skill_thirst + :skill_thirst)>100,100,(skill_thirst + :skill_thirst)),skill_health = IF( (skill_health + :skill_health)>100,100,(skill_health + :skill_health)) WHERE rabbit_id = :id_nabz");
		$infos_product = infos_product($id_product);
		$pt_angry = $infos_product['prdct_angry_pt'];
		$pt_thirst = $infos_product['prdct_thirst_pt'];
		$pt_health = $infos_product['prdct_health_pt'];
		
		$query->bindValue(':skill_angry',$pt_angry);
		$query->bindValue(':skill_thirst',$pt_thirst);
		$query->bindValue(':skill_health',$pt_health);
		$query->bindValue(':id_nabz',$id_nabz);
		
		$query->execute();

		return($query->rowCount() == 1);
	}

	//Update quantity of used product
	function update_quantity($id_product)
	{
		$pdo = PDO2::getInstance();

		$query = $pdo->prepare("UPDATE tbl_cart SET product_quantity = product_quantity - 1 WHERE product_id = :id_product");
		
		$query->bindValue(':id_product',$id_product);
		$query->execute();
		
		return($query->rowCount() == 1);
		}
		
	//Delete a product in cart
	function delete_product_incart($id_product)
	{
		
		$pdo = PDO2::getInstance();
		
		$quantity = display_quantity($id_product, $_SESSION['id']);
		
		$query = $pdo->prepare("DELETE FROM tbl_cart WHERE product_id = :id_product");
		
		$query->bindValue(':id_product',$id_product);
		$query->execute();
		
		return($query->rowCount() == 1);
		}
?>