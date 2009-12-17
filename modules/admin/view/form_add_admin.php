<?php
    require_once("global/menu_admin.php");
	
    $menu_admin = display_menu_admin();
    echo $menu_admin;
    
?>
<h2>Administration</h2>

<?php

if (!empty($msg_confirm)) {

	echo '<ul>'."\n";

	foreach($msg_confirm as $m) {

		echo '	<li>'.$m.'</li>'."\n";
	}

	echo '</ul>';
}

if (!empty($errors_form_cat)) {

	echo '<ul>'."\n";

	foreach($errors_form_cat as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}

$form_add_cat->fieldsets(array("Ajout d'un catégorie." => array('cat_name','cat_description','cat_image')));

echo $form_add_cat;

if (!empty($errors_form_product)) {

	echo '<ul>'."\n";

	foreach($errors_form_product as $e) {

		echo '	<li>'.$e.'</li>'."\n";
	}

	echo '</ul>';
}

$form_add_product->fieldsets(array("Ajout d'un produit." => array('product_name','product_cat','product_description','product_qty','product_portion','product_price','product_img','product_health_pt','product_angry_pt','product_thirst_pt')));

echo $form_add_product;

?>