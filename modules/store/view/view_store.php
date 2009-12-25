<h2>Rabbit Store</h2>
<p>Vous trouverez ici tous les bons produits dont vous avez besoin pour bien vous occuper de votre lapin.</p>
<p>Solde de votre compte : <?php echo user_balance($_SESSION['id']); ?> nab$z</p>


<?php
//Display Errors
 if (!empty($error_buy)) {

	echo '<ul id = "ul_error">'."\n";

	foreach($error_buy as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}?>

<?php 
//Display Messages of confirmation
if (!empty($msg_confirm)) {

	echo '<ul id = "ul_msg_confirm">'."\n";

	foreach($msg_confirm as $msg) {

		echo '	<li>'.$msg.'</li>'."\n";
	}

	echo '</ul>';
}?>

<?php
	for($cat=1; $cat <=$nbcat;$cat=$cat+1)
	{
			$nbr=0;
			$nbr_product=number_product_cat($cat);
			//print_r($nbr_product['nbr']);
			$nbr =$nbr_product['nbr'];
			$infos_product = read_infos_product($cat);
		//Print products of a cat
		$i=0;
		echo '<fieldset>';
		echo '<legend><h3>'.cat_name($cat).'</h3></legend>';
		echo '<table id=\'table_shop\'><tbody><tr>';
		while($i < $nbr)
		{	
					echo '<td style="vertical-align: top;">';
					echo '<table id=\'table_product\'><tbody><tr>';
					echo '<td>';
			   		echo '<img src='.PATH_IMAGE_STORE.$infos_product['product_image'][$i].'>'.'<br \>';
			   		echo $infos_product['product_name'][$i].'<br \>';
			   		echo $infos_product['product_description'][$i].'<br \>';
			   		echo '</td>';
					echo '<td>';
					echo 'Quantité disponible '.$infos_product['product_quantity'][$i].'<br \>';
					echo 'Prix : '.$infos_product['product_price'][$i].' nab$z'.'<br \>';
					echo 'Points de santé : '.$infos_product['prdct_health_pt'][$i].'<br \>';
					echo 'Points de faim : '.$infos_product['prdct_angry_pt'][$i].'<br \>';
					echo 'Points de soif : '.$infos_product['prdct_thirst_pt'][$i].'<br \>';
					echo 'Portions : '.$infos_product['product_portion'][$i].'<br \>';
					echo  $form_buy[$infos_product['product_id'][$i]];
					echo '</td></tr></tbody>';
					echo '</table></td>';
					
			$i =$i+1;
			
			if($i%2 ==0){ //Break line every 2products
				echo '</tr>';	
			}
		}
		echo '</tr></tbody></table>';
		echo '</fieldset>';
		
	}
?>