<?php
	define ('BASE_URL', 'http://api.violet.net/vl/FR/');
	global $zcr_id;
	
	$sn = "0019DB002091" ;
	$token ="1194475678";
	
	$sn = "12345";
	$token = "54321";
	
	$sequence ='sn='.$sn.'&token='.$token;
	$url = BASE_URL."api.jsp?".$sequence."&action=10";
	
	$violet_response = file_get_contents(BASE_URL."api.jsp?".$sequence."&action=10");
	
	echo file_get_contents(BASE_URL."api.jsp?".$sequence."&action=10");
	
	echo '<br />'.$violet_response.'<br />';
	
	preg_match("/<rabbitName>.+<\/rabbitName>/", $violet_response,$nab_name);
	print_r($nab_name);
	
	echo '<br />';
	
	echo $nab_name[0];
	if($nab_name == null)
		{
			echo "invalid";
			return true;
		}else{
			echo "ovalid";
			return false;
			}
?>
