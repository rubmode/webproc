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

    public function login( $type = null )
    {   
        
        if( $type == 'dropbox' ):
            $access = $this->Dropbox->access;
            $dbURL          = 'https://www.dropbox.com/1/oauth2/authorize';
            $redirect_uri   = base_url().'app/check';
            header('Location: '.$dbURL.'?client_id='.$access['key'].'&response_type=code&redirect_uri='.$redirect_uri);
        endif;

        if( $type == 'google' ):

        endif;

    }

    public function logout()
    {
        $this->session->sess_destroy();
        header('Location: '.base_url().'home');
    }

    public function xmlFile( $files = null )
    {
        $nombre_archivo = $files['userfile']['name'];
        $tipo_archivo = $files['userfile']['type'];
        
        if (!(strpos($tipo_archivo, "xml"))) :
            return false;
        else :
            if(isset($files["userfile"]) && is_uploaded_file($files['userfile']['tmp_name'])):
                $fp = fopen($files['userfile']['tmp_name'],"r") or die("File not recognized");
                $archivo="";
                while($line = fgets($fp)){  
                    $archivo .= $line;
                } 
                fclose($fp);
                return $archivo;
            else :
                return false;
            endif;
        endif;
    }

    public function getCurrentUrl() 
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}