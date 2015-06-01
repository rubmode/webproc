<?php use Slim\Slim;
require_once    'include/class.Proc.php';
/**
*   =================================
*   Description: User Api methods
*   @author ruben@w3are.mx
*   @version 1.0
*   =================================
*
*
*/

#sample function
// function sample(){
//     $request = Slim::getInstance()->request();
//     $data = json_decode($request->getBody());
//     var_dump($data);
// }


function initialization(){
	$proc = new Proc;
	$proc->_put();
}

function putNewUser()
{
	$proc = new Proc;
	$data = array(
		'email' 	=> 	'ruben.loguz@gmail.com',
		'password'	=>	'abcd1234',
		'date'		=> 	date("Y-m-d H:i:s") 
	);
	$result = $proc->_post('users', $data);
	die($result);
}

?>