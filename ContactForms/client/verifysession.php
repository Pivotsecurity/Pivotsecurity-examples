<?php

	function mainscript($email,$key,$sessionid){
		if (!empty($email) && !empty($key)){
			if (!empty($sessionid)){
				$data = array(
					'email' => $email,
					'sessionid' => $sessionid
				);
				$result = verifySession($key, $data);
				if ($result){
					return true;
				}else{
				}
			}
        }
        return false;
    }

	function verifySession($key, $data){
		$payload = json_encode($data);
		$ch = curl_init('https://api.pivotsecurity.com/api/account/verifysession');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch,CURLOPT_USERPWD, $key . ":" ); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload))
		);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
 		$result = curl_exec($ch);
 		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 		curl_close($ch);
 		
 		return $httpcode;
	}
	
	
