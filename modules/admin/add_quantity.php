<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		
		include PATH_LIB.'form.php';
		//require_once(PATH_MODEL.'store.php');
		require_once(PATH_MODEL.'admin.php');
		//Create a form to add quantity for each product available in the DB
		
		$array_id = array();
		$array_id = all_products_id();
		
		//Generate a buy form for each product, index is depending on product id
		
			foreach($array_id as $value)
			{
				$form_stock[$value] = new Form('form_stock'.$value);
				
				$form_stock[$value]->method('POST');
				
				$form_stock[$value]->add('Text','prdct_quantity')
									->label('Quantité à ajouter');
				
				$form_stock[$value]->add('Submit', 'submit')
							->value("Ajouter au stock");
				
				$form_stock[$value]->bound($_POST);
			}
		
		//Errors and confirm array
		$error_stock = array();
		$msg_confirm = array();
		
		foreach ($array_id as $value)
		{
			//which product admin wants to add
				if($form_stock[$value]->is_valid($_POST))
				{
					$new_quantity = $form_stock[$value]->get_cleaned_data('prdct_quantity');
					if ($new_quantity != "")
					{
						add_quantity($value,$new_quantity);
						$msg_confirm = "Ajout de quantité correctement réalisé.";
					}else{
						$error_stock = "La quantité rentrée est non valide, merci de réessayer.";
						include PATH_VIEW.'form_add_quantity.php';
						}					
				}//end is_valid
				
		}//end of foreach
		
		include PATH_VIEW.'form_add_quantity.php';
	}//end user_admin	
?>