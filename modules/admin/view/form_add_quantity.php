<?php
    require_once("global/menu_admin.php");
	
    $menu = display_menu_admin();
    echo $menu;
    
?>

<h2>Stocks des produits</h2>
<?php
//Display Errors
 if (!empty($error_stock)) {

	echo '<ul id = "ul_error">'."\n";

	foreach($error_stock as $e) {

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
		$i=0; //iterative value
		echo '<table id=\'table_products\'><tbody><tr>';
		//display each product as in the rabbit store
		foreach($array_id as $value){
			$infos_product=infos_product_admin($value); //read infos about product
			
					if($infos_product['product_quantity']==0) //display the case in red if there is no more in stock
					{
						$style = 'style ="background-color: red;"';
					}else{$style="";}		
			
					echo '<td style="vertical-align: top;">';
					echo '<table id=\'table_product_stock\' '.$style.'><tbody><tr>';
					echo '<td>';
			   		echo '<img src='.PATH_IMAGE_STORE.$infos_product['product_image'].'>'.'<br \>';
			   		echo $infos_product['product_name'].'<br \>';
			   		echo $infos_product['product_description'].'<br \>';
			   		echo '</td>';
					echo '<td>';
					echo 'Quantité disponible : '.$infos_product['product_quantity'].'<br \>';
					echo  $form_stock[$value];
					echo '</td></tr></tbody>';
					echo '</table><td>';
					
				$i =$i+1;
				
				if($i%2 ==0){ //Break line every 2products
					echo '</tr>';	
				}
			}
			
			echo '</tr></tbody></table>';
			
?>