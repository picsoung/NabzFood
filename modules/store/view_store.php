<h2>Rabbit Store</h2>
<p>Vous trouverez ici tous les bons produits dont vous avez besoin pour bien vous occuper de votre lapin.</p>
<p>Balance de votre compte : <?php echo user_balance($_GET['id']); ?> nab$z</p>

<?php if (!empty($error_buy)) {

	echo '<ul>'."\n";

	foreach($error_buy as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}?>