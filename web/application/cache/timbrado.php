<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timbrado extends CI_Controller {
	public function __construct(){
			parent::__construct();
    }
	public function readXML(){
		$nombre_archivo = $_FILES['userfile']['name'];
        $tipo_archivo = $_FILES['userfile']['type'];
        if (!(strpos($tipo_archivo, "xml"))) :
        	echo "<br>El archivo debe ser XML";
    	else :
            echo "Cargando Archivo...<br>";
         	if (isset($_FILES["userfile"]) && is_uploaded_file($_FILES['userfile']['tmp_name'])):
                $fp = fopen($_FILES['userfile']['tmp_name'],"r") or die("No se pudo leer el archivo");
                $comprobante="";
                while($line = fgets($fp)){
                    $comprobante .= $line;
                }                    
                fclose($fp);
                echo "Archivo Procesado...<br>";
	        else :
                 echo "Ocurrio algún error al Cargar el archivo, intentelo nuevamente...";
            endif;
        endif;
	}
}