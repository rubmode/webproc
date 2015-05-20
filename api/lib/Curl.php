<?php

/**
 * Static class to handle CURL methods
 *
 * @author Aldo Barba <a@inmediatum.com>
 */

class Curl{

	private function __construct(){}

	public static function get($url, array $data = array()){
		$ch = self::_getDefault($url, 'GET', $data);
		return self::_getResponse($ch);
	}

	public static function put($url, array $data = array()){
		$ch = self::_getDefault($url, 'PUT', $data);
		return self::_getResponse($ch);
	}

	public static function post($url, array $data = array()){
		$ch = self::_getDefault($url, 'POST', $data);
		return self::_getResponse($ch);
	}

	public static function delete($url, array $data = array()){
		$ch = self::_getDefault($url, 'DELETE');
		return self::_getResponse($ch);
	}

	public static function _getResponse($ch){
		$response = curl_exec($ch);
		if(curl_error($ch))
			$response = curl_error($ch);
		curl_close($ch);
		return $response;
	}

	public static function _getDefault($url, $method, array $data = array()){
		
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		if(count($data)){
			$data_string = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
			);
		}
		
		return $ch;
	}
}