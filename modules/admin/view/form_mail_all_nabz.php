<h2>Rédaction d'un message à tout les lapins</h2>

<?php
    //Display Messages of confirmation
    if (!empty($msg_confirm)) {
    
            echo '<ul id = "ul_msg_confirm">'."\n";
    
            foreach($msg_confirm as $msg) {
    
                    echo '	<li>'.$msg.'</li>'."\n";
            }
    
            echo '</ul>';
    }
    echo $form_mail_nabz;
?>
<a href="<?php echo 'index.php?module=admin&action=nabz&id='.$_SESSION['id'];?>">Revenir à la liste</a>