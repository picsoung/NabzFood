<?php
	header("Content-type: image/png"); 
    $im = ImageCreate (200, 10) or die ("Erreur lors de la création de l'image");         
    $couleur_fond = ImageColorAllocate ($im, 160, 210, 240); 
    $couleur = ImageColorAllocate ($im, 255, 0, 0);
    ImagePng ($im);
?>