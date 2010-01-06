<?php
    require_once("global/menu_nabz.php");
	
    $menu = display_menu();
    echo $menu;
    
?>

<h2>Infos concernant votre lapin : <?php echo htmlspecialchars($nabz_name); ?></h2>

<p>Pour t'occuper de ton lapin navigue dans les onglets.</p>
<h3>Son état de santé</h3>
<p>
	<?php display_skill($id_nabz); ?>
</p>

<a href="<?php echo 'index.php?module=nabz&amp;action=edit_nabz&id='.$_SESSION['id'];?>">Modifier mon profil</a>&nbsp;
<a href="<?php echo 'index.php?module=nabz&amp;action=delete_nabz&id='.$_SESSION['id'];?>">Supprimer son profil</a>