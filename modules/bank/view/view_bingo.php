<?php
    require_once("global/menu_bank.php");
	
    $menu = display_menu_bank();
    echo $menu;
    
?>
<h2>Bingo</h2>
<table id="table_bingo"><tr>
    <td id="bingo_desc">
        <?php
                //Display Errors
             if (!empty($error_bingo)) {
            
                    echo '<ul id = "ul_error">'."\n";
            
                    foreach($error_bingo as $e) {
            
                            echo '	<li>'.$e.'</li>'."\n";
                    }
            
                    echo '</ul>';
            }
        ?>
        <p>Sélectionnez votre numéro pour jouer au tirage de la semaine et peut-être gagner le gros lot.</p>
        <p>Solde de votre compte : <img src="<?php echo PATH_IMAGE_RESSOURCE."donate.png";?>"><?php echo user_balance($_SESSION['id']); ?> nab$z</p>
        
        <p>Prix d'un ticket : <?php echo $price; ?> nab$z</p>
        <p>Jackpot : <?php echo $jackpot;?> nab$z</p>
    </td>
    <td id="game_bingo">
        
            <table id='table_game_bingo'><tbody>
            
            <?php
            
                echo '<tr>';
                foreach ($tbx as $key =>$value)
                {
                    //Break line each 10numbers
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
            <tr>
            <table id="last_winners"><tbody>
                <th>Derniers gagnants</th>
                <?php
                    foreach($array_winners as $key => $value)
                    {
                        if($key%2!=0){echo '<tr class=\'alt\'>';}else{echo '<tr>';}
                        echo '<td>'.$array_winners[$key].'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody></table>
            </tr>
    </td>
</tr></table>