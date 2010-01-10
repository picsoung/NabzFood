<?php
    require_once("global/menu_admin.php");
	
    $menu = display_menu_admin();
    echo $menu;
    
?>
<h2>Gestion des produits</h2>

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
			   		echo '<b>'.$infos_product['product_name'].'</b>'.'<br \>';
			   		echo $infos_product['product_description'].'<br \>';
			   		echo '</td>';
					echo '<td>';
					echo 'Quantité disponible : '.$infos_product['product_quantity'].'<br \>';
					echo  $form_update_product[$value];
					echo '</td></tr></tbody>';
					echo '</table><td>';
					
				$i =$i+1;
				
				if($i%2 ==0){ //Break line every 2products
					echo '</tr>';	
				}
			}
			
			echo '</tr></tbody></table>';
			
?>