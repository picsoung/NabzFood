<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>Nabzfood - Un lapin qui a de l'appétit</title>

	<meta http-equiv="Content-Language" content="fr" />

	<link rel="stylesheet" href="style/global.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/nabz.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/table_product.css" type="text/css" media="screen" />

</head>

<body>

	<h1>Nabzfood - Un lapin qui a de l'appétit</h1>

<div id="left">
<?php include 'global/menu.php'; ?>
<?php 
if(user_connected() && user_has_nabz($_SESSION['id'])>0){include 'global/nabz_summary.php';} ?>
</div>
	<div id="centre">