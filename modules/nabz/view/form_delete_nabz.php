<h2> Supprimer <?php include PATH_MODEL.'nabz.php';
$infos_nabz = read_infos_nabz($_GET['id']);
$nabz_name = $infos_nabz['rabbit_name'];
echo htmlspecialchars($nabz_name); ?> de votre compte </h2>
<?php
	echo $form_delete_nabz;
?>