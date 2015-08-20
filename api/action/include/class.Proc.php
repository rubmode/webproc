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
		$server 	= 	'localhost';
		$user 		= 	'root';
		$pass 		= 	'';
		$database 	= 	'webproc';
		$connection = 	new mysqli($server, $user, $pass, $database);
		
		if ($connection->connect_error) {
    		return (array( 'wp_error' => $connection->connect_errno ));
		}
		
		return $connection;
	}
	
	public function _put($table = null, $id = null)
	{
		$db = $this->connect_db();
		
		die($result);
	}

	public function _post($table = null, $object = null)
	{
		$db 	= $this->connect_db();
		$data 	= '';
		$values = '';
		
		if( $object['password'] ):
			$object['password'] = $this->_mkMd5($object['password']);
		endif;
		
		foreach ($object as $key => $value) 
		{
			$data = $data . $key . ', ';
			$values = $values . '"' . mysql_escape_string($value) . '", ';
		}
		
		$data 	= substr($data, 0, -2);
		$values = substr($values, 0, -2);
		$query = "INSERT INTO " . $table . " ( " . $data . " ) VALUES  ( " . $values . ")";
		$result = $db->query( $query );
		$db->close();
		
		die(json_encode($result));
	}
	
	public function _get($table = null, $object)
	{	
		if( !$table ) :
			die(json_encode(array('error'=>'No table defined.')));
		endif;
		
		$db = $this->connect_db();
		$query = "SELECT ".$object['cell']." FROM ".$table." WHERE ".$object['object']." = '".$object['value']."'";
		$db->real_query($query);
		$result = $db->use_result();

		if( $result->num_rows == 0 ) :
			die(json_encode(array('error'=>'No data found.')));
		endif;
		
		$response = array();
		$row = $result->fetch_assoc();
		
		foreach ($row as $key => $value) 
		{
			$response[$key] = $value;
		}
		
		die (json_encode($response));
	}
	
	public function _delete()
	{
		die();
	}
	
	private function _mkMd5($string)
	{
		$add = 'webproc2015';
		return md5($string.$add);
	}

}

?>