<div id="menu">
		<?php if (!user_connected()) {?><ul>
			<li><a href="index.php?module=members&amp;action=signup">Inscription</a></li>
			<li><a href="index.php?module=members&amp;action=login">Connexion</a></li>
		</ul>
		<?php }else{ ?>
		<p> Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?>.</p>
		<ul>
			<li><a href="<?php echo 'index.php?module=nabz&amp;action=mynabz&id='.$_SESSION['id'];?>">Mon Lapin</a></li>
			<li><a href="<?php echo 'index.php?module=store&amp;action=buy&id='.$_SESSION['id'];?>">Rabbit Store</a></li>
			<li><a href="<?php echo 'index.php?module=bank&amp;action=bank&id='.$_SESSION['id'];?>">Banque</a></li>
			<li><a href="index.php?module=members&amp;action=logout">Déconnexion</a></li>
		</ul>
			<a href="<?php echo 'index.php?module=members&amp;action=profile&id='.$_SESSION['id'];?>"><img src="<?php echo PATH_IMAGE_RESSOURCE."user.png";?>">Profil</a>
			<?php if (user_admin()){?>
				<a href="<?php echo 'index.php?module=admin&amp;action=add_productandcat&id='.$_SESSION['id'];?>"><img src="<?php echo PATH_IMAGE_RESSOURCE."cog.png";?>">Administration</a>
		<?php }}?>
		
 
	</div>