<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		include PATH_LIB.'form.php';
		require_once(PATH_MODEL.'admin.php');
		
		//Create a form to add quantity for each product available in the DB
		$array_id = array();
		$array_id = all_products_id();
		
		$tbx = array();
		$choice_cat = load_cat();
		
		//Generate a buy form for each product, index is depending on product id
			foreach($array_id as $value)
			{
				$infos_product=infos_product_admin($value);
				$form_update_product[$value] = new Form('form_update_product'.$value);
				
				$form_update_product[$value]->method('POST');
				$form_update_product[$value]->add('Text','product_name')
								->label('Nom du produit')
								->value($infos_product['product_name']);
								
				$form_update_product[$value]->add('Select','product_cat')
								->label('Catégorie du produit')
								->choices($choice_cat)
								->value($infos_product['product_cat_id']-1); //because a select object has an array for all the option value. The first index is 0, and in DB the cat_id is 1.
								
				$form_update_product[$value]->add('Text','product_description')
								->label('Description du produit')
								->value($infos_product['product_description']);
								
				$form_update_product[$value]->add('Text','product_qty')
								->label('Quantité du produit')
								->value($infos_product['product_quantity'].' ');
								
				$form_update_product[$value]->add('Text','product_portion')
								->label('Nombre de portions par produit')
								->value($infos_product['product_portion'].' ');
								
				$form_update_product[$value]->add('Text','product_price')
								->label('Prix du produit')
								->value($infos_product['product_price'].' ');
								
				$form_update_product[$value]->add('Text','product_img')
								->label('Image du produit')
								->value($infos_product['product_image']);
								
				$form_update_product[$value]->add('Text','product_health_pt')
								->label('Point de santé du produit')
								->value($infos_product['prdct_health_pt'].' ');
								
				$form_update_product[$value]->add('Text','product_angry_pt')
								->label('Point de faim du produit')
								->value($infos_product['prdct_angry_pt'].' ');
								
				$form_update_product[$value]->add('Text','product_thirst_pt')
								->label('Point de soif du produit')
								->value($infos_product['prdct_thirst_pt']).' ';
								
				$form_update_product[$value]->add('Submit','submit')
							->value('Valider');

				
				$form_update_product[$value]->bound($_POST);
			}
			
			//Errors and confirm array
			$error_update = array();
			$msg_confirm = array();
		
			foreach ($array_id as $value)
			{
				if($form_update_product[$value]->is_valid($_POST))
				{
					list($product_name, $product_cat, $product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt) = $form_update_product[$value]->get_cleaned_data('product_name', 'product_cat','product_description','product_qty','product_portion','product_price','product_img','product_health_pt','product_angry_pt','product_thirst_pt');
					$test_product =  update_product($product_name, $product_cat,$product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt,$value);
				if($test_product == true){
					$msg_confirm[] = "Votre produit a bien était mis à jour.";
					header("Location: index.php?module=admin&action=manage_product&id=".$_SESSION['id']); //Reload page
				}else{
					$error_update[] = "Erreur dans la mis à jour du produit.";
				} //end test_product

				}//end of is_valid
			}//end of foreach
		include PATH_VIEW.'form_edit_product.php';
	}//end user_admin
?>