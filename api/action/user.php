<?php use Slim\Slim;

/**
*   =================================
*   Description: User Api methods
*   @author ruben@w3are.mx
*   @version 1.0
*   =================================
*
*
*/

function AddNewUser()
{	
	$result = json_encode(array('result'=>'error,', 'desc'=>'No data saved.'));

	$request = Slim::getInstance()->request();
    $data = $request->getBody();

	$auth = auth($request->getHost(),$request->post('app_key'));
	
	if ( $auth['result'] != 'success' ):
		die ( json_encode($auth) );
	endif;

	$date 		= date("Y-m-d H:i:s");
	$email 		= $request->post('email');
	$password 	= _mkMd5($request->post('password'));
	$token 		= _mkMd5($request->post('email').$request->post('password').$date);
	
	$check = json_decode(CheckUser($email));

	if (!$check->result) : 
		$result = json_encode(array('result'=>'error', 'desc'=>'No data returned.'));
	endif;

	if ( $check->result != 0 ) : 
		$result = json_encode(array('result'=>'error', 'desc'=>'User already exist.'));
	else :

		$db = new Database();
		$data = array(
			'email' 	=> 	$db->escapeString($email),
			'password'	=>	$db->escapeString($password),
			'token' 	=>	$db->escapeString($token),
			'date'		=> 	$date
		);
		
		$db = new Database();
		$db->connect();
		$db->insert('_users', $data);
		$res = $db->getResult(); 
		
		if(isset($res[0])) :
			$result = json_encode(array('result'=>'success', 'data'=>array('email'=>$email, 'token'=>$token)));
		else:
			$result = json_encode(array('result'=>'error,', 'desc'=>'No data saved.'));
		endif;
	endif;

	die ($result);
}	

function CheckUser( $email = null )
{
	$db = new Database();
	$db->connect();
	$db->select('_users','email', NULL,'email="'.$email.'"','_id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	
	if(isset($res[0])) : 
		$response = json_encode(array('result'=>1, 'data'=>$res[0]));
	else :
		$response = json_encode(array('result'=>0, 'desc'=>'No data found.'));
	endif;

	return ($response);
}


?>