<?php
/**
 * Description of Curl
 * @author jorgeGonzalez v1
 * @author CesarChavez v2
 * @author RubénLópez v3
 * @version V2.0
 */
class Curl {
    static $URL;
    public function __construct($api=null){
        self::$URL = $api;
    }
    /**
    * this function use curl to transfer data post and return one response encoded json format    
    * @param string $url url referenciada al metodo de la api
    * @param string $method metodo de referencia por el cual se enviaran o recibiran los datos Get/Update/Save/Delete
    * @param array $data variables que se enviaran por post
    * @return  array  regresa una cadena en formato json
    */
    public function curlData($url=NULL,$method = "Get",$data = NULL, $background = NULL){
        if($url == NULL) echo "Error: there's not an URL.";
        try {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            
            
            if($method!="File"){
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
            }
            if($method=="Get"){
                curl_setopt($curl, CURLOPT_HTTPGET, 1);//solo para get
                if($background!=NULL){
                    curl_setopt($curl, CURLOPT_FRESH_CONNECT, $background);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                }
            }
            if($method=="Delete")
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');//solo en delete    
            if($data!=NULL){
                curl_setopt($curl, CURLOPT_POST, 1);//envio post
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//solo para enviar data post
            }
            if($background==NULL){
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $json_response = curl_exec($curl);
            }else{                
                curl_exec($curl);
            }            

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ( $status != 200 ) {
                die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_error " . curl_errno($curl));
            }
            curl_close($curl);
            
            if($background==NULL){
                $response = $json_response;
                return $response;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }//end curlData


    public function curlBackground($url=NULL,$method = "Get",$data = NULL){
        try{       
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ( $status != 200 ) {
                die("Error: call to URL $url failed with status $status, curl_error " . curl_error($ch) . ", curl_error " . curl_errno($ch));
            }      
            curl_close($ch); 
            unset($ch); 
            $success = strpos($response, "1");
            if($success===false){
                return $response;
            }else{
                return true;
            }
        }catch(Exception $e){
            echo "error procesing draft: $draft_id ".$e->getMessage();
        }
    return false;
    }

    public function run(){
        echo '{"Curl_Running":"ok"}';
    }

}
?>
