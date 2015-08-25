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
	$request = Slim::getInstance()->request();
    $data = $request->getBody();

	auth($request->getHost(),$request->post('app_key'));

	$date 		= date("Y-m-d H:i:s");
	$email 		= $request->post('email');
	$password 	= _mkMd5($request->post('password'));
	$token 		= _mkMd5($request->post('email').$request->post('password').$date);
	
	CheckIfNewUser($email);

	$db = new Database();
	$data = array(
		'email' 	=> 	$db->escapeString($email),
		'password'	=>	$db->escapeString($password),
		'token' 	=>	$db->escapeString($token)
	);	
	
	$new_user_id = CreateUser($data);
	$meta = CreateUserMetaData($new_user_id);
	$account = CreateUserAccountData($new_user_id);

	die(json_encode(array('result'=>'success', 'desc'=>'El usuario se registró con éxito.', 'data'=>array('email'=>$email, 'token'=>$token))));
}

function LoginUser()
{	
	$request = Slim::getInstance()->request();
    $data = $request->getBody();

	auth($request->getHost(),$request->post('app_key'));

	$date 		= date("Y-m-d H:i:s");
	$email 		= $request->post('email');
	$password 	= _mkMd5($request->post('password'));
	$token 		= _mkMd5($request->post('email').$request->post('password').$date);
	
	$user = json_decode(CheckIfRegisteredUser($email));
	
	if ($password != $user->data->password):
		die(json_encode(array('result'=>'error', 'desc'=>'Password incorrecto.')));
	endif;
	
	$db = new Database();

	die(json_encode(array('result'=>'success', 'desc'=>'Bienvenido de nuevo: '.$email, 'data'=>array('email'=>$email, 'token'=>$token))));
}	

function CreateUser($data = null)
{	
	$db = new Database();
	$db->connect();
	$db->insert('_users', $data);
	$res = $db->getResult(); 
	
	if(!isset($res[0])) :
		die(json_encode(array('result'=>'error,', 'desc'=>'CreateUser: Hubo un error de comunicación con la base de datos.')));
	endif;
	
	return($res[0]);
}

function CreateUserMetaData($user_id = null)
{	
	$db = new Database();
	$date = date("Y-m-d H:i:s");
	$data = array(
		'wp_id' 	=> 	$user_id,
		'date'		=>	$date
	);
	$db->connect();
	$db->insert('_user_meta', $data);
	$res = $db->getResult(); 
	
	if(!isset($res[0])) :
		die(json_encode(array('result'=>'error,', 'desc'=>'CreateUserMetaData: Hubo un error de comunicación con la base de datos.')));
	endif;
	
	return($res[0]);
}

function CreateUserAccountData($user_id = null)
{	
	$db = new Database();
	$data = array(
		'wp_id' 	=> 	$user_id,
		'status'		=>	$db->escapeString('trial')
	);
	$db->connect();
	$db->insert('_user_accounts', $data);
	$res = $db->getResult(); 
	
	if(!isset($res[0])) :
		die(json_encode(array('result'=>'error,', 'desc'=>'CreateUserAccountData: Hubo un error de comunicación con la base de datos.')));
	endif;
	
	return($res[0]);
}

function CheckIfNewUser($email = null)
{
	$db = new Database();
	$db->connect();
	$db->select('_users','email', NULL,'email="'.$email.'"','_id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	
	if(isset($res[0])) : 
		die(json_encode(array('result'=>'error', 'desc'=>'Este usuario ya existe.')));
	endif;

	return (json_encode(array('result'=>'success', 'desc'=>'Este usuario es nuevo.')));
}

function CheckIfRegisteredUser($email = null)
{
	$db = new Database();
	$db->connect();
	$db->select('_users','*', NULL,'email="'.$email.'"','_id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
	$res = $db->getResult();
	
	if(!isset($res[0])) : 
		die(json_encode(array('result'=>'error', 'desc'=>'Este usuario no está registrado.')));
	endif;

	return (json_encode(array('result'=>'success', 'desc'=>'Es un usuario registrado.', 'data'=>$res[0])));
}


?>