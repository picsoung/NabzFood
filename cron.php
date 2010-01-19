<?php
	// Initialisation
	include 'global/init.php';
	require_once(PATH_MODEL.'cron.php');
	require_once(PATH_MODEL.'nabz.php');
	$tbx_rabbits_id = list_all_rabbits();
	foreach ($tbx_rabbits_id as $rabbit)
	{
		udapte_angry_skill($rabbit);
		udapte_health_skill($rabbit);
		udapte_thirst_skill($rabbit);
	}//end foreach
?>