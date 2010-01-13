<h2>Éditer informations du Lapin</h2>
<?php
    //Display Errors
     if (!empty($error_update)) {
    
            echo '<ul id = "ul_error">'."\n";
    
            foreach($error_update as $e) {
    
                    echo '	<li>'.$e.'</li>'."\n";
            }
    
            echo '</ul>';
    } 
    //Display Messages of confirmation
    if (!empty($msg_confirm)) {
    
            echo '<ul id = "ul_msg_confirm">'."\n";
    
            foreach($msg_confirm as $msg) {
    
                    echo '	<li>'.$msg.'</li>'."\n";
            }
    
            echo '</ul>';
    }
    
    echo $form_edit_nabz;
    
?>
<a href="<?php echo 'index.php?module=admin&action=nabz&id='.$_SESSION['id'];?>">Revenir à la liste</a>