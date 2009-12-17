<?php
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
					echo 'i = '.$i.$form_buy[$infos_product['product_id'][$i]];
					echo '</td></tr></tbody>';
					echo '</table></td>';
					
			$i =$i+1;
			
			if($i%2 ==0){ //Break line every 2products
				echo '</tr>';	
			}
		}
		echo '</tr></tbody></table>';
		echo '</fieldset>';
		?>