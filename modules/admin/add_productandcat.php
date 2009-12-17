<?php
	if(!user_admin()) {
		include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		
		include PATH_LIB.'form.php';
		include PATH_MODEL.'admin.php';
		
		//Add a category of product
		$form_add_cat = new Form('form_add_cat');
		
		$form_add_cat->method('POST');
		
		$form_add_cat->add('Text','cat_name')
					->label('Nom de la catégorie');
					
		$form_add_cat->add('Text','cat_description')
					->label('Description de la catégorie');
		
		$form_add_cat->add('Text','cat_image')
					->label('URL de l\'image de la catégorie');
					
		$form_add_cat->add('Submit','submit')
					->value('Valider');
		
		//Add a product
		$form_add_product = new Form('form_add_product');
		
		$form_add_product->method('POST');
		
		$choice_cat = load_cat();
		
		$form_add_product->add('Text','product_name')
						->label('Nom du produit');
		$form_add_product->add('Select','product_cat')
						->label('Catégorie du produit')
						->choices($choice_cat);
		$form_add_product->add('Text','product_description')
						->label('Description du produit');
		$form_add_product->add('Text','product_qty')
						->label('Quantité du produit');
		$form_add_product->add('Text','product_portion')
						->label('Nombre de portions par produit');
		$form_add_product->add('Text','product_price')
						->label('Prix du produit');
		$form_add_product->add('Text','product_img')
						->label('Image du produit');
		$form_add_product->add('Text','product_health_pt')
						->label('Point de santé du produit');
		$form_add_product->add('Text','product_angry_pt')
						->label('Point de faim du produit');
		$form_add_product->add('Text','product_thirst_pt')
						->label('Point de soif du produit');
		$form_add_product->add('Submit','submit')
					->value('Valider');
		
		//Errors array
		$errors_form_cat = array();
		$errors_form_product = array();
		
		$msg_confirm = array();
		
		if($form_add_cat->is_valid($_POST)) {
			list($cat_name,$cat_desc,$cat_img) = $form_add_cat->get_cleaned_data('cat_name','cat_description','cat_image');
				
				//want to add a category
				if(!empty($cat_name) && !empty($cat_desc) && !empty($cat_img))
				{
					$test = add_category($cat_name,$cat_desc,$cat_img);
					
					if($test == true)
					{
						$msg_confirm[]="Votre catégorie a bien était ajoutée.";
					}else{
							$error =& $test;
					
							if (23000 == $error[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL
								preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_pb);
								$value_pb = $value_pb[1];
				
								if ($email_addr == $value_pb) {
				
									$errors_form_cat[] = "Cette catégorie existe déjà.";
								} else {
				
									$errors_form_cat[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
								}
							} else {
								$errors_form_cat[] = sprintf("Cette catégorie existe déjà.");
							}
						}//end of $test
					}//end of empty(cat_)
		}else if($form_add_product->is_valid($_POST))
		{
			list($product_name, $product_cat, $product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt) = $form_add_product->get_cleaned_data('product_name', 'product_cat','product_description','product_qty','product_portion','product_price','product_img','product_health_pt','product_angry_pt','product_thirst_pt');
	
			//want to add a product
				$test_product = add_product($product_name, $product_cat,$product_desc,$product_qty,$product_portion, $product_price, $product_img, $product_health_pt, $product_angry_pt, $product_thirst_pt);
				if($test_product == true){
					$msg_confirm[] = "Votre produit a bien était ajouté.";
				}else{
						$error =& $test;
					
							if (23000 == $error[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL
								preg_match("`Duplicate entry '(.+)' for key \d+`is", $error[2], $value_pb);
								$value_pb = $value_pb[1];
				
								if ($email_addr == $value_pb) {
				
									$errors_form_cat[] = "Cette catégorie existe déjà.";
								} else {
				
									$errors_form_cat[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
								}
							} else {
								$errors_form_cat[] = sprintf("Cette catégorie existe déjà.");
							}
					}//end of test_product
			
			}//end is_valid form_add_cat
		
			include PATH_VIEW.'form_add_admin.php';
	}//end of user_admin
?>