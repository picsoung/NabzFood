<h2>Modification des informations de votre Lapin</h2>

<?php

if (!empty($msg_confirm)) {

	echo '<ul>'."\n";
		echo '	<li>'.$msg_confirm.'</li>'."\n";

	echo '</ul>';
}

if (!empty($error_edit)) {

	echo '<ul>'."\n";

	foreach($error_edit as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}

//$form_edit_nabz->fieldsets(array("Modification du serial ." => array('serial')));

echo $form_edit_nabz;
?>