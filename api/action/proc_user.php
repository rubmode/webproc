<?php

    use Slim\Slim;

    #sample function
    function sample(){

        $request = Slim::getInstance()->request();
        $data = json_decode($request->getBody());

        var_dump($data);
           
    }

?>