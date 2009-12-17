<h2>Modification de votre profil utilisateur</h2>

<?php

if (!empty($msg_confirm)) {

	echo '<ul>'."\n";
	echo '	<li>'.$msg_confirm.'</li>'."\n";

	echo '</ul>';
}

if (!empty($errors_form_infos)) {

	echo '<ul>'."\n";

	foreach($errors_form_infos as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}

$form_edit_infos->fieldsets(array("Modification de l'e-mail ." => array('email_addr')));

echo $form_edit_infos;

if (!empty($errors_form_password)) {

	echo '<ul>'."\n";

	foreach($errors_form_password as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}

$form_edit_password->fieldsets(array("Modification du mot de passe" => array('old_password', 'new_password', 'verif_new_password')));

echo $form_edit_password ;

?>