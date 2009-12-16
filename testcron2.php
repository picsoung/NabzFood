<?php
		$productPrices=array();
$productPrices['clothing']['shirt'] = 20.00; 
$productPrices['clothing']['pants'] = 22.50; 
$productPrices['linens']['blanket'] = 25.00; 
$productPrices['linens']['bedspread'] = 50.00; 
$productPrices['furniture']['lamp'] = 44.00; 
$productPrices['furniture']['rug'] = 75.00; 

print_r($productPrices);

echo "<table border=1>"; 
foreach( $productPrices as $category ) 
{ 
	foreach( $category as $product => $price ) 
	{ 
		$f_price = sprintf('%01.2f', $price); 
		echo '<tr><td>$product:</td> 
		<td>\$$f_price</td></tr>'; 
	} 
} 
echo '</table>'; 
?>