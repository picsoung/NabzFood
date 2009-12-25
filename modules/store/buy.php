<?php
	if(!user_connected()|| !verify_get_id($_GET['id'],$_SESSION['id']))
	{
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else if (!user_has_nabz($_SESSION['id'])>0)
	{
		include PATH_GLOBAL_VIEW.'error_no_nabz.php';
	}
	else{
		include PATH_MODEL.'store.php';
		include PATH_LIB.'form.php';
	
		//count the number of category
		$nbcat = number_category();
		
		
		//array where we will stock the product_id
		$tbx_index = array();
		
		//Repeat for each category
		for($cat=1; $cat <=$nbcat;$cat=$cat+1)
		{
			$nbr = number_product_cat($cat);
			
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
		}//end of for loop in cat
		
		$error_buy = array();
		$msg_confirm = array();
		
		foreach ($tbx_index as $value)
			{
				//which product user wants to buy
				if($form_buy[$value]->is_valid($_POST))
				{
					$infos_product_tobuy = infos_product($value);
					
					//Dont have enough money in the account
					if(user_balance($_SESSION['id']) < $infos_product_tobuy['product_price'])
					{
						$error_buy[] = "Solde insuffisant pour acheter cet objet, vous pouvez recharger votre compte dans la partie Banque";
					}
					elseif(uniq_prdct_in_cart($value,$_SESSION['id']) != 0) //if the object is already in the cart
					{
						add_product_incart($value,$_SESSION['id']);
						$msg_confirm[] = "Achat effectué avec succès, vous disposiez déjà de ce produit dans votre inventaire, votre achat s'est ajouté à votre stock déjà existant"; 
					}else
					{
						buy_product($value,$_SESSION['id']);
						$msg_confirm[] = "Achat effectué avec succès, le produit a été ajouté a votre inventaire."; 

					}//end of user_balance
					
				}
			
			}//end of foreach
	include PATH_VIEW.'view_store.php';		
	}//end of user_connected
	
	
?>