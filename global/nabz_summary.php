<div id="nabz_summary">
	<?php 
	//require_once("menu_nabz.php");?>
	<?php
	require_once(PATH_MODEL.'nabz.php');
	require_once("global/menu_nabz.php");
	$infos_nabz = read_infos_nabz($_SESSION['id']);
				
		if($infos_nabz !== false) {
			$id_nabz = $infos_nabz['rabbit_id'];
			$nabz_name = $infos_nabz['rabbit_name'];
			$_SESSION['nabzname']=$nabz_name;
			
			//extract skills of the nabz
			$skill_nabz = read_skill_nabz($id_nabz);
				
			$skill_angry = $skill_nabz['skill_angry'];
			$skill_thirst = $skill_nabz['skill_thirst'];
			$skill_health = $skill_nabz['skill_health'];
		}
		display_avatar_name();
	?><br />
	<?php display_skill($id_nabz); /*call display skill function */?>
</div>