<?php
	//display this page only if the user is connected
	if(!user_connected() || !verify_get_id($_GET['id'],$_SESSION['id'])){
		include PATH_GLOBAL_VIEW.'error_not_connected.php';
	}else {
		include PATH_LIB.'form.php';
    	require_once(PATH_MODEL.'store.php');
    	require_once(PATH_MODEL.'nabz.php');
		
		//Generate a use form for each product on the cart, index is depending on cat id
				$item_cat= array();
				$item_cat=display_item_in_cat('3',$_GET['id']); //2 corresponds to feeding item category	
			
				//array where we will stock the product_id
				$tbx_use_index = array();
		
				foreach($item_cat as $value){
					$form_use[$value] = new Form('form_use'.$value);
					
					$form_use[$value]->method('POST');
					
					$form_use[$value]->add('Submit', 'submit')
								->value("Utiliser");
					
					$form_use[$value]->bound($_POST);
					
					//construct a array with the product_id
					array_push($tbx_use_index,$value);
				}
				
		//Arrays for error and confirm message 
		$error_buy = array();
		$msg_confirm = array();
		
		//Treatment for each form
		foreach ($tbx_use_index as $value)
			{
				//which product user wants to buy
				if($form_use[$value]->is_valid($_POST))
				{
						//add nutrionals aspect to rabbit skill
						use_product($value,$_SESSION['id_nabz']);
					
						$quantity = display_quantity($value, $_SESSION['id']);
						//Operation on quantity, delete if we you the last in cart or -1 if there is still some in
						if($quantity-1 == 0)
						{
							delete_product_incart($value);
							header("Location: index.php?module=nabz&action=treat&id=".$_GET['id']); //Reload page
						}else{
							update_quantity($value);
						}
						
						$msg_confirm[] = "Action effectuée avec succès, votre lapin se sent déjà mieux.";
				}//end of is_valid
			
			}//end of foreach
		
		include PATH_VIEW.'view_treat.php';
	}//end user_connected
?>