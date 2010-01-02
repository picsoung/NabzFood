<h2>Connexion au site</h2>

<p>Si vous n'êtes pas encore inscrit, vous pouvez le faire en <a href="index.php?module=members&amp;action=signup">cliquant sur ce lien</a>.</p>

<p>Si vous avez oublié votre mot de passe vous pouvez utiliser le formulaire de renvoi pour le retrouver : <a href="index.php?module=members&amp;action=reset_pwd"> formulaire de renvoi de mot de passe </a> </p>
<?php

if (!empty($errors_login)) {

	echo '<ul>'."\n";
	
	foreach($errors_login as $e) {
	
		echo '	<li>'.$e.'</li>'."\n";
	}
	
	echo '</ul>';
}

echo $form_login;
?>