<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*   
*   @author Rubén López <ruben.lopez@inmediatum.com>
*   @version 1.0
*
*/

class Proc_Controller extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->_curl = new Curl( $this->config->item('api_url') );
    
    }

    public function checkAppKey ()
    {
        $cookie_name = 'app_key';
        $app_key = $this->config->item('app_key');
        
        if ( !$app_key || $app_key == '' ) :
            return (array('res'=>'error', 'desc'=>'No hay "app_key" configurada'));
        else :
            $cookie_value = $app_key;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 60), "/");
        endif;
        
        return (array('res'=>'success', 'desc'=>'Tenemos una "app_key" configurada.'));
    }

    public function checkAuthKey ()
    {
        $cookie_name = 'auth_key';
        if ( !isset($_COOKIE[$cookie_name]) ) :
            return (array('res'=>'error', 'desc'=>'No tenemos llave de usuario.'));
        endif;
        return (array('res'=>'success', 'desc'=>'Tenemos una llave de usuario.'));
    }

    public function logout()
    {
        unset($_COOKIE['auth_key']);
        setcookie('auth_key', null, -1, '/');
    }

}