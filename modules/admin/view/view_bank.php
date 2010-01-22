<?php
    require_once("global/menu_admin.php");
	
    $menu = display_menu_admin();
    echo $menu;
    
?>
<fieldset>
    <legend><h2>Bingo</h2></legend>
    <table id="tbl_adm_bingo">
	<td>
	    <?php
		echo $form_bingo;
	    ?>
	</td>
	<td>
	    <p>Nombre de tickets joués : <?php echo $number_ticket_sold ?></p>
	    <p>Somme dépensée en tickets : <?php echo ($number_ticket_sold*$price).' nab$z'; ?></p>
	    <?php
		echo $form_distrib;
	    ?>
	</td>
    </table>
</fieldset>