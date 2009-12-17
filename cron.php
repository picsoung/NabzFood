<?php
// Initialisation
include 'global/init.php';
	require_once(PATH_MODEL.'cron.php');
	require_once(PATH_MODEL.'nabz.php');
	$tbx_rabbits_id = list_all_rabbits();
	print_r($tbx_rabbits_id);
	foreach ($tbx_rabbits_id as $rabbit)
	{
		udapte_angry_skill($rabbit);
		udapte_health_skill($rabbit);
		udapte_thirst_skill($rabbit);
		echo 'rabbit '.$rabbit;
		
		$infos_rabbit = read_skill_nabz($rabbit);
		print_r($infos_rabbit);
		
		echo $infos_rabbit['skill_angry'].' '.$infos_rabbit['skill_thirst'].' '.$infos_rabbit['skill_health'];
		
		if($infos_rabbit['skill_angry']<50)
		{
			echo "J'ai faim";
		}elseif($infos_rabbit['skill_thirst']<50)
		{
			echo "J'ai soif";
			}elseif($infos_rabbit['skill_health']<50)
		{
			echo "Je suis malade";
			}
		
	}//end foreach
?>