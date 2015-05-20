<?php
    
    /**
    *   =================================
    *   Description: User Api methods
    *   @author ruben@w3are.mx
    *   @version 1.0
    *   =================================
    *
    *
    */

    use Slim\Slim;

    #sample function
    function sample(){

        $request = Slim::getInstance()->request();
        $data = json_decode($request->getBody());

        var_dump($data);
           
    }

?>