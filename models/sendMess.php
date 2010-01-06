<?php
	$snSendMess = htmlspecialchars(urlencode(utf8_decode($nabz_serial)));//htmlspecialchars(urlencode(utf8_decode($_POST['serial'])));
	$tokenSendMess = htmlspecialchars(urlencode(utf8_decode($nabz_token)));
	$mess = htmlspecialchars(urldecode(utf8_decode($message)));
	$mess = urlencode(stripslashes(stripslashes($mess)));
	
	
	if ($snSendMess && $tokenSendMess && $mess) {
		//header('Content-Type: text/xml charset=UTF-8');
		//header('Content-Disposition: inline; filename=sendMess.xml');
		
		$sendResult = utf8_decode(curlGet('http://api.nabaztag.com/vl/FR/api.jsp?sn=' . $snSendMess . '&token=' . $tokenSendMess . '&tts=' .$mess));
		
		echo ucfirst(convertResultSendMess($sendResult));
	} else {
		
	}
	
	
	
	
	
	
	/* FONCTIONS UTILSE POUR L'ENVOI DE MESSAGE */
	
	function curlGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$page = curl_exec($curl);
		curl_close($curl);

		if ($page != NULL) {
			return $page;
		} else {
			return '<h1>Une erreur est survenue</h1>';
		}
	}
	
	function convertResultSendMess($result) {
		$messResult = preg_replace('#<\?xml version="1.0" encoding="UTF-8"\?><rsp><message>#i', '', $result);
		$messResult = preg_replace('#</message><comment>[a-zA-Z ]+</comment></rsp>
#i', '', $messResult);
		
		if (preg_match('#TTSSEND#i',$result) || preg_match('#TTSSENT#i',$result) || preg_match('#MESSAGESENT#i',$result)) {
			return 'Le message est bien parti';
		} else {
			$result = preg_replace('#<\?xml version="1.0" encoding="UTF-8"\?><rsp>#i', '', $result);
			$result = preg_replace('#</rsp>
#i', '', $result);
			return $result;
		}
	}
?>