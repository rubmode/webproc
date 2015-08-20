<?php use Slim\Slim;

/**
*   =================================
*   Description: Auth Api methods
*   @author ruben@w3are.mx
*   @version 1.0
*   =================================
*
*
*/

$admin = 'admin';

function getAppToken($app_key = null, $admin_secret = null)
{
	global $admin;

	$request = Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $host = $request->getHost();

    if( !$admin_secret || $admin_secret != $admin ) :
    	die(json_encode(array('result'=>'error')));
    endif;

	$string = $host.$app_key.$admin_secret;
	
	$app_token = _mkMd5($string);
	
	die(json_encode(array('result'=>'success', 'data' => array('token'=>$app_token, 'host'=>$host, 'app_key'=>$app_key))));
}

function auth($host = null, $app_key = null)
{
	global $admin;

	$db = new Database();
	$db->connect();
	$db->select('_keys', '*', null, 'host="'.$host.'"'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	
	$token = _mkMd5($res[0]['host'].$res[0]['key'].$admin);
	if($token != $app_key) : 
		$response = array('result'=>0, 'desc'=>'Unauthorized');
	else :
		$response = array('result'=>'success', 'desc'=>'Authorized');
	endif;

	return ($response);
	
}

function _mkMd5($string)
{
	$add = 'webproc2015';
	return md5($string.$add);
}

?>