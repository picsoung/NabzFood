<?php
    require_once("global/menu_bank.php");
	
    $menu = display_menu_bank();
    echo $menu;
    
?>
<h2>Bingo</h2>
<p>Sélectionnez votre numéro pour jouer au tirage de la semaine et peut-être gagner le gros lot.</p>
<p>Solde de votre compte : <img src="<?php echo PATH_IMAGE_RESSOURCE."donate.png";?>"><?php echo user_balance($_SESSION['id']); ?> nab$z</p>

<table id='table_bingo'><tbody>

<?php

    echo '<tr>';
    foreach ($tbx as $key =>$value)
    {
        if($key%10==0)
        {
            echo '</tr><tr>';
        }
        
        //Display numbers depend on avaibility
        if($tbx[$key]['usr_id']==0)
        {
            echo '<td class=\'num_available\'>'."<a href=\"index.php?module=bank&action=bingo_buy_ticket&id=".$_SESSION['id']."&number=".$tbx[$key]['number']."\">".$tbx[$key]['number'].'</a>'.'</td>';
        }
        else
        {
            echo '<td class=\'num_not_available\'>'.'</td>';
        }

    }

?>
</tbody></table>