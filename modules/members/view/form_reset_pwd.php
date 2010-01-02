<h2>Renvoi du mot de passe oublié et/ou du lien d'activation</h2>

<p>Entrez votre adresse e-mail et vous recevrez l'instant d'après, un mél contenant vos informations de connexion login/mot de passe ainsi que votre lien pour valider votre compte si vous ne l'avez pas déjà fait.<p>

<?php
    //Display Errors
     if (!empty($error_reset_pwd)) {
    
            echo '<ul id = "ul_error">'."\n";
    
            foreach($error_reset_pwd as $e) {
    
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
    echo $form_reset_pwd;
?>