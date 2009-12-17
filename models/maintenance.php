<?php
	function maintain_angry(){
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_rabbit_skill SET skill_angry = skill_angry - :maintain_value");
		
		$query->bindValue(":maintain_value",10);
		
		return $pdo->execute();
		}
?>