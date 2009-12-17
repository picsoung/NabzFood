<?php
    require_once("global/menu_nabz.php");
	
    $menu = display_menu();
    echo $menu;
    
?>
<h2>Abreuver son lapin</h2>

<table>
	<tr><!-- First line --!>
		<td><!-- First column --!>
		<?php
		display_avatar_name(); 
		display_skill($_SESSION['id_nabz']); ?>
		</td>
		<td id="td_secondcol"><!-- Second line --!>
		<?php 
		if($item_cat != NULL){
		echo 'Pour abreuver votre lapin vous disposez de :';}
		else{echo 'Vous ne disposez d\'aucun produit pour abreuver votre lapin :( ';}
		?>
		<?php 
		
		//display each product as in the rabbit store
		foreach($item_cat as $value){
			$infos_product=infos_product($value);
			
					echo '<table id=\'table_product_profile\'><tbody><tr>';
					echo '<td>';
			   		echo '<img src='.PATH_IMAGE_STORE.$infos_product['product_image'].'>'.'<br \>';
			   		echo $infos_product['product_name'].'<br \>';
			   		echo $infos_product['product_description'].'<br \>';
			   		echo '</td>';
					echo '<td>';
					echo 'Points de santé : '.$infos_product['prdct_health_pt'].'<br \>';
					echo 'Points de faim : '.$infos_product['prdct_angry_pt'].'<br \>';
					echo 'Points de soif : '.$infos_product['prdct_thirst_pt'].'<br \>';
					echo 'Quantité disponible : '.display_quantity($infos_product['product_id'],$_SESSION['id']).'<br \>';
					echo  $form_use[$value];
					echo '</td></tr></tbody>';
					echo '</table>';
			
			}
			
		?>
		</td>
</table>