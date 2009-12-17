<?php
	if(!user_connected())
	{
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else{
		include PATH_MODEL.'store.php';
		include PATH_VIEW.'view_store.php';
		
		include PATH_LIB.'form.php';
	
		//count the number of category
		$nbcat = number_category();
		$nbcat = $nbcat['nbr'];
		
		//array where we will stock the product_id
		$tbx_index = array();
		
		for($cat=1; $cat <$nbcat;$cat=$cat+1)
		{
			$nbr=0;
			$nbr_product=number_product_cat($cat);
			//print_r($nbr_product['nbr']);
			$nbr =$nbr_product['nbr'];
			$infos_product = read_infos_product($cat);
			
			//Generate a buy form for each product, index is depending on product id
			for($i=0;$i<$nbr;$i=$i+1)
			{
				$index = $infos_product['product_id'][$i];
				$form_buy[$index] = new Form('form_buy'.$index);
				
				$form_buy[$index]->method('POST');
				
				$form_buy[$index]->add('Submit', 'submit')
							->value("Ajouter au panier");
				
				$form_buy[$index]->bound($_POST);
				
				//construct a array with the product_id
				array_push($tbx_index,$index);
			}
			
			include PATH_VIEW.'view_table.php';
		}//end of for loop in cat
		
		$error_buy = array();
		
		foreach ($tbx_index as $value)
			{
				//which product user wants to buy
				if($form_buy[$value]->is_valid($_POST))
				{
					$infos_product_tobuy = infos_product($value);
					
					//Dont have enough money in the account
					if(user_balance($_GET['id']) < $infos_product_tobuy['product_price'])
					{
						$error_buy[] = "Solde insuffisant pour acheter cet objet, vous pouvez recharger votre compte dans la partie Banque";
					}
					elseif(uniq_prdct_in_cart($value,$_GET['id']) != 0) //if the object is not already in the cart
					{
						buy_product($value,$_GET['id']);
					}else
					{
						add_product($value,$_GET['id'],uniq_prdct_in_cart($value,$_GET['id']));
					}//end of user_balance
					
					
					//echo print_r(infos_product($value));
					//buy_product($value,$_GET['id'],nbr_portion_prdct($value));
				include PATH_VIEW.'view_store.php';
				}
			
			}
			
	}//end of user_connected
	
	
?>