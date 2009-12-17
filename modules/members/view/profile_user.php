<h2> Profil de <?php echo htmlspecialchars($_SESSION['pseudo']); ?> </h2>

<p>
	<span class="label_profile"> Email : </span> <?php echo htmlspecialchars($email_addr); ?> <br \>
	<span class="label_profile"> Dernière connexion : </span> <?php echo htmlspecialchars($lastconnect); ?> <br \>
</p>

<a href="<?php echo 'index.php?module=members&amp;action=edit_profile&id='.$_SESSION['id'];?>">Modifier son profil</a>