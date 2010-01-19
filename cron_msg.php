<?php
// Initialisation
include 'global/init.php';
	require_once(PATH_MODEL.'cron.php');
	require_once(PATH_MODEL.'nabz.php');
        require_once(PATH_LIB."nabz_lib.php");
	$tbx_rabbits_id = list_all_rabbits();
	foreach ($tbx_rabbits_id as $rabbit)
	{
		$infos_rabbit = read_skill_nabz($rabbit);
		$sntoken_rabbit = get_serial_and_token($rabbit);
		print_r($sntoken_rabbit);
		$nabz_serial = $sntoken_rabbit['rabbit_serial'];
		$nabz_token = $sntoken_rabbit['rabbit_token'];
		
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
		
                    //When lang will be implemented in ddb
                    /*if($lang != 'Français')
		    {
			$lang ="us";
		    }else {
			$lang = "fr";
			}*/
		if ($message != "")//only if we have something to send
                {
		    //Send message with lib+API
                    $nabaztag = new Nabaztag($nabz_serial,$nabz_token);
		    $nabaztag->dire($message);
		    $nabaztag->send();
		    $msg_confirm[]=$nabaztag->getAPImsg();
                }
		//include PATH_LIB.'sendMess.php';
		
	}//end foreach
?>