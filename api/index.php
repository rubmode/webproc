<?php

#Slim configuration
require 		'Slim/Slim.php';
require_once 	'config.php';

#Lib: Included classes to work with
require_once 	'lib/Curl.php';
require_once 	'lib/Dropbox/autoload.php';

#Actions: Included functions to work with
require_once 	'action/user.php';


#Slim initialization
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


#Is the API running?
$app->get('/',  function () {

		$api = array( 'API running' => 'yes' );
        echo json_encode($api);
    }
);



#ApiMethods_
$app->get('/init', 'initialization');
$app->get('/adduser', 'putNewUser');

$app->run();