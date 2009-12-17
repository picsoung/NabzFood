<?php
	function add_member_in_db($username,$password,$email_addr,$hash_validation)
	{
		$pdo= PDO2::getInstance();
		
		$query = $pdo->prepare("INSERT INTO tbl_user SET user_pseudo = :username, user_pass = :password, user_mail = :email_addr, hash_validation = :hash_validation, user_balance = :CASH_START, user_lastconnect = NOW()");
		
		$query->bindValue(":username",$username);
		$query->bindValue(":password",$password);
		$query->bindValue(":email_addr",$email_addr);
		$query->bindValue(":hash_validation",$hash_validation);
		$query->bindValue(":CASH_START",CASH_START);
				
	if($query->execute()) {
			return $pdo->lastInsertId();
	}
	print_r($query->errorInfo());
	return $query->errorInfo();
}
		
?>