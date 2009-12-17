<?php
//Login Form
include PATH_LIB.'form.php';

$form_login = new Form('form_login');

$form_login->method('POST');

$form_login->add('Text', 'username')
			->label("Votre nom d'utilisateur");

$form_login->add('Password', 'password')
			->label("Votre mot de passe");
			
$form_login->add('Checkbox','auto_login')
			->required("false")
			->label("Connexion automatique");

$form_login->add('Submit', 'submit')
			->value("Connectez-moi !");

$form_login->bound($_POST);
?>
<?php
//verification of the login form

$errors_login = array();

if ($form_login->is_valid($_POST)){
		
		list($username, $password) = $form_login->get_cleaned_data('username','password');
		
		$id_user = valid_login($username,sha1($password));
		
		if(false !== $id_user)
		{
			$infos_user = read_infos_user($id_user);
			
			$_SESSION['id'] = $id_user;
			$_SESSION['pseudo'] = $username;
			$_SESSION['email'] = $infos_user['user_mail'];
			
			if(false !== $form_login->get_cleaned_data('auto_login'))
			{
				$browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
				$hash_cookie = sha1('592a23516c'.$username.'3b665d692a'.sha1($password).'307e352c2b'.$browser.'7e79437856');
				
				setcookie('id', $_SESSION['id'], strtotime("+1 hour"), '/');
				setcookie('auto_login', $hash_cookie,strtotime("+1 hour"), '/');
			}
			
			include PATH_VIEW.'login_ok.php';
		} else {
			
			$errors_login[] = "Compte inexistant ou mot de passe non valide";
			
			// Suppression des cookies de connexion automatique
		setcookie('id', '',0);
		setcookie('auto_login', '',0);
			
			include PATH_VIEW.'form_login.php';
		}	
		
	
} else {
	
	include PATH_VIEW.'form_login.php';
	}
?>