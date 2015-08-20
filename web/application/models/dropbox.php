<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dropbox extends CI_Model {

    public $access = array('key' => '6h8ouoraj1ouo2p', 'secret' => 'qvzc7zwyx3v8ccn');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getTheToken( $code = null )
    {
        $params = array(
            'code'          => $code,
            'grant_type'    => utf8_encode('authorization_code'),
            'client_id'     => $this->access['key'],
            'client_secret' => $this->access['secret'],
            'redirect_uri'  => base_url().'app/check'
        );
        
        $ch = curl_init('https://api.dropbox.com/1/oauth2/token');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                                                                                                                      
        $result = curl_exec($ch);
        return $result;
        
    }

    public function getUserInfo( $access_token = null )
    {
        $ch = curl_init('https://api.dropbox.com/1/account/info?access_token='.$access_token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }

    public function uploadFile( $access_token = null, $file = null, $path = null )
    {
            
        $filePathName = $file['tmp_name'];
        $url = 'https://api-content.dropbox.com/1/files_put/auto/'.$path.'/'.$file['name'].'?access_token='.$access_token;

        $headers = array(
            "Content-Type: ".$file['type'].", Content-Length: ".$file['size']
        );

        $fh = fopen($filePathName, "rb");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($filePathName));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $apiResponse = curl_exec($ch);

        fclose($fh);

        die ($apiResponse);

    }

    public function deleteFile( $access_token = null, $file = null, $path = null )
    {

        $params = array(
            'root'          => 'auto',
            'path'          => $path.'/'.$file,
            'access_token'  => $access_token,
        );
        
        $ch = curl_init('https://api.dropbox.com/1/fileops/delete');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                                                                                                                      
        $result = curl_exec($ch);

        die ($result);

    }

    private function createFolder( $access_token = null, $folder = null )
    {
        $params = array(
            'root'          => 'auto',
            'path'          => $folder,
            'access_token'  => $access_token,
        );
        
        $ch = curl_init('https://api.dropbox.com/1/fileops/create_folder');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                                                                                                                      
        $result = curl_exec($ch);
        return $result;
    }

    public function getFileMetadata( $access_token = null, $path = null )
    {
        $ch = curl_init('https://api.dropbox.com/1/metadata/auto/'.$path.'?list=true&access_token='.$access_token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }

}
?>