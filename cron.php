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
		
		$infos_rabbit = read_skill_nabz($rabbit);
		$sntoken_rabbit = get_serial_and_token($rabbit);
		print_r($sntoken_rabbit);
		$nabz_serial = $sntoken_rabbit['rabbit_serial'];
		$nabz_token = $sntoken_rabbit['rabbit_token'];
		
		echo 'angry '.$infos_rabbit['skill_angry'];
		if($infos_rabbit['skill_angry']<50)
		{
			$message = "J'ai faim";
		}
		if($infos_rabbit['skill_thirst']<50)
		{
			$message .= "J'ai soif";
		}
		if($infos_rabbit['skill_health']<50)
		{
			$message .="Je suis malade";
		}
		//$nabz_serial = $tbx_rabbits_id['rabbit_serial'];
		echo 'nabz serial'.$nabz_serial;
		include PATH_LIB.'sendMess.php';
		
	}//end foreach
?>