<?php
	//Decrease angry skill of all rabbits
	function udapte_angry_skill()
	{

		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = IF( (skill_angry - :new_skill )<0,0,(skill_angry - :new_skill ))");
		
		$query->bindValue(":new_skill",10);
		$query->execute();
	}
	
	//Decrease thirst skill of all rabbits
	function udapte_thirst_skill()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_thirst = IF( (skill_thirst - :new_skill )<0,0,(skill_thirst - :new_skill ))");
		
		$query->bindValue(":new_skill",10);
		$query->execute();
	}
	
	//Decrease health skill of all rabbits
	function udapte_health_skill()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_health = IF( (skill_health - :new_skill )<0,0,(skill_health - :new_skill ))");
		
		$query->bindValue(":new_skill",10);
		$query->execute();
	}
	
	//Get an array with all the rabbit id
	function list_all_rabbits()
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT rabbit_id, rabbit_serial, rabbit_token FROM tbl_rabbit");
		$query->execute();
		
		if ($result = $query->fetchAll(PDO::FETCH_COLUMN)); {
				$query->closeCursor();
				return $result;
		}
		return false;
	}
	
	//Function send a message of angry
	function function_send_angry_msg($id_nabz)
	{
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT rabbit_token FROM tbl_rabbit WHERE rabbit_id = :id_nabz");
		$query->bindValue(":id_nabz", $id_nabz);
		
		$token = $query->execute();
		
		$query = $pdo->prepare("SELECT rabbit_serial FROM tbl_rabbit WHERE rabbit_id = :id_nabz");
		$query->bindValue(":id_nabz", $id_nabz);
		
		$serial = $query->execute();
		
		
	}
	
	//Get serial and token of a nabz depending on his id
	function get_serial_and_token($id_nabz)
	{
		$pdo = PDO2::getInstance();
		$query = $pdo->prepare("SELECT rabbit_serial, rabbit_token FROM tbl_rabbit WHERE rabbit_id = :id_nabz",array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
		$query->bindValue(":id_nabz", $id_nabz);
		
		$query->execute();
		$tbx= array();
		while ($row= $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$tbx['rabbit_serial']= $row[0];
			$tbx['rabbit_token']=$row[1];
		} 
		
		//$tbx is an array with all the informations of a product
		return $tbx;
	}
?>