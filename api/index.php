<?php

#Slim configuration
require 		'Slim/Slim.php';
require_once 	'config.php';

#Lib: Included classes to work with
require_once 	'lib/Curl.php';
require_once 	'lib/Dropbox/autoload.php';

#Actions: Included functions to work with
require_once    'action/include/mysql_crud.php';
require_once 	'action/auth.php';
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

#UserMethods_
$app->post('/user/addnew', 'AddNewUser');

#Get an app_token for an app
$app->get('/auth/app/get_token/:app_key/:admin_secret', 'getAppToken');

#Let's run
$app->run();