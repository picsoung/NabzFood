<div id="menu">
	
		<h2>Menu</h2>
		
		<ul>
			<li><a href="index.php">Accueil</a></li>
		</ul>
		
		<h3>Espace membre</h3>
		<?php if (!user_connected()) {?><ul>
			<li><a href="index.php?module=members&amp;action=signup">Inscription</a></li>
			<li><a href="index.php?module=members&amp;action=login">Connexion</a></li>
		</ul>
		<?php }else{ ?>
		<p> Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?>.</p>
		<ul>
			<li><a href="<?php echo 'index.php?module=members&amp;action=profile&id='.$_SESSION['id'];?>">Profil</a></li>
			<li><a href="<?php echo 'index.php?module=nabz&amp;action=mynabz&id='.$_SESSION['id'];?>">Mon Lapin</a></li>
			<li><a href="<?php echo 'index.php?module=store&amp;action=buy&id='.$_SESSION['id'];?>">Rabbit Store</a></li>
			<li><a href="<?php echo 'index.php?module=bank&amp;action=bank&id='.$_SESSION['id'];?>">Banque</a></li>
			<li><a href="index.php?module=members&amp;action=logout">Déconnexion</a></li>
			<?php if (user_admin()){?>
			<li><a href="<?php echo 'index.php?module=admin&amp;action=add_productandcat&id='.$_SESSION['id'];?>">Administration</a></li>
		</ul>
		<?php }}?>
 
	</div>