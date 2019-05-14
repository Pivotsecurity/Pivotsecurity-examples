<?php

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: GET,POST,OPTIONS');
		header('Access-Control-Allow-Credential: true');
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers, Authorization');
		
		$email = '';$key =''; $code =''; $uid = '';
		if (isset($_GET['email']))
			$email = $_GET['email'];
		if (isset($_GET['key']))
			$key = $_GET['key'];
		if (isset($_GET['code']))
			$code = $_GET['code'];
		if (isset($_GET['uid']))
			$code = $_GET['uid'];

		if (!empty($email) && !empty($key)){
			if (!empty($code)){
				$data = array(
					'uid' => $uid,
					'email' => $email,
					'code' => $code
				);
				$result = getCode($key, $data);
				if ($result){
					$ret = json_decode($result, true);
					echo $ret['sessionid'];
				}
				exit;
			}else{
				$data = array(
					'uid' => $uid,
					'email' => $email,
					'channel' => "email"
				);
				$result = getData($key, $data);
				if (!empty($result)){
        			include ('clientverifycode.html');
        		}else{
        			include('clientverifyerror.html');
        		}
			}
		}else{
        	include('clientverify.html');
        }
        

	function getData($key, $data){
		$payload = json_encode($data);
		$ch = curl_init('https://api.pivotsecurity.com/api/customer/create');
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
 		if ($httpcode == 200 || $httpcode == 201 || $httpcode == 204){
 			return $httpcode;
 		}
 		return null;
	}
	
	function getCode($key, $data){
		$payload = json_encode($data);
		$ch = curl_init('https://api.pivotsecurity.com/api/customer/verify');
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
 		if ($httpcode == 200){
 			return $result;
 		}
 		return null;
	}
	
	
