<h2>Rédaction d'un mail à <?php echo $pseudo;?> </h2>
<?php
    echo $form_mail_user;
?>
<a href="<?php echo 'index.php?module=admin&action=users&id='.$_SESSION['id'];?>">Revenir à la liste</a>
