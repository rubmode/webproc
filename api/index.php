<?php

#Slim configuration
require 'Slim/Slim.php';
require_once 'config.php';

#Lib: Included classes to work with
require_once 'lib/Curl.php';
require_once 'lib/FacturacionModerna.php';
require_once 'lib/Dropbox/autoload.php';

#Actions: Included functions to work with
require_once 'action/cfdi-facturacionmoderna.php';
require_once 'action/cfdi-dropbox.php';

#Create objects

#Slim initialization
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->get('/',  function () {
        echo '{"run":"ok"}';
    }
);

#ApiMethods_
$app->get( '/dropbox/appKey', 'getAppKey');
$app->post( '/dropbox/token', 'getToken');
$app->post( '/timbrar', 'timbrar');
$app->post( '/cancelar', 'cancelar');

#ApiRunning_
$app->run();