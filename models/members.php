<?php

	//Confirm Account function
	function valid_account($hash_validation) {
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_user SET hash_validation = '' WHERE hash_validation = :hash_validation");
		
		$query->bindValue(':hash_validation', $hash_validation);
		
		$query->execute();
		
		return($query->rowCount() == 1);
		}
	
	//Login function	
	function valid_login($username,$password) {
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT user_id FROM tbl_user WHERE user_pseudo = :username AND user_pass = :password");
	
		$query->bindValue(':username', $username);
		$query->bindValue(':password', $password);
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		
			$query->closeCursor();
			return $result['user_id'];
		}
		return false;
	}
	
	//Read Infos function
	function read_infos_user($id_user) {
		
		$pdo = PDO2::getInstance();
	
		$query = $pdo->prepare("SELECT user_pseudo, user_pass, user_mail, user_lastconnect, hash_validation FROM tbl_user WHERE user_id = :id_user");
	
		$query->bindValue(':id_user', $id_user);
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		
			$query->closeCursor();
			return $result;
		}
		return false;
	}
	
	//Update email adress function
	function update_mail_user($id_user, $email_addr) {
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_user SET user_mail = :email_addr WHERE user_id = :id_user");
		
		$query->bindValue(':email_addr',$email_addr);
		$query->bindValue(':id_user',$id_user);
		//$query->execute();
		
		$error = $pdo->errorCode();
		
		return $query->execute();
	}
	
	//Update user password function
	function update_password_user($id_user,$password) {
		
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("UPDATE tbl_user SET user_pass = :password WHERE user_id = :id_user");
		
		$query->bindValue(':password',sha1($password));
		$query->bindValue(':id_user',$id_user);
		
		$query->execute();
		return($query->rowCount() == 1);
	}
	
	//Find user_id thanks to his email_addr
	function find_user_id($email){
		$pdo = PDO2::getInstance();
		
		$query = $pdo->prepare("SELECT user_id FROM tbl_user WHERE user_mail = :email_addr ");
		
		$query->bindValue(':email_addr',$email);
		
		$query->execute();
		
		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		
			$query->closeCursor();
			return $result['user_id'];
		}
			return false;
	}
	
	//Generate a new password (script founded on sentosoft.com)
	function gen_new_pwd()
	{
		
		$password_length = 9;

		function make_seed() {
		  list($usec, $sec) = explode(' ', microtime());
		  return (float) $sec + ((float) $usec * 100000);
		}
		
		srand(make_seed());
		
		$alfa = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		$token = "";
		for($i = 0; $i < $password_length; $i ++) {
		  $token .= $alfa[rand(0, strlen($alfa)-1)];
		}    
		return $token;
	}
?>