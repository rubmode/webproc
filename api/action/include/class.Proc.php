<?php

/**
*   =================================
*   @author ruben@w3are.mx
*   @version 1.0
*   =================================
*/

class Proc {
	public function __construct(){}
	private function connect_db() 
	{
		$server 	= 'localhost';
		$user 		= 'root';
		$pass 		= '';
		$database 	= 'webproc';
		$connection = new mysqli($server, $user, $pass, $database);
		return $connection;
	}
	public function _put($table = null, $id = null)
	{
		die();
	}
	public function _post($table = null, $object = null)
	{
		$db 	= $this->connect_db();
		$data 	= '';
		$values = '';

		if( $object['password'] ):
			$object['password'] = md5($object['password']);
		endif;

		foreach ($object as $key => $value) {
			$data = $data . $key . ', ';
			$values = $values . '"' . mysql_escape_string($value) . '", ';
		}

		$data 	= substr($data, 0, -2);
		$values = substr($values, 0, -2);

		$query = "INSERT INTO " . $table . " ( " . $data . " ) VALUES  ( " . $values . ")";
		
		$result = $db->query( $query );

		die($result);
	}
	public function _get()
	{
		die();
	}
	public function _delete()
	{
		die();
	}
	private function md5($string)
	{
		$add = 'webproc';
		return md5($$string.$add);
	}
}

?>