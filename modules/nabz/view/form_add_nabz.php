<h2>Ajouter un Lapin</h2>

<?php

if (!empty($error_nabz)) {

	echo '<ul>'."\n";
	
	foreach($error_nabz as $e) {
	
		echo '	<li>'.$e.'</li>'."\n";
	}
	
	echo '</ul>';
}

echo $form_add_nabz;
?>