<?php

    use Slim\Slim;

    function acceder($rfc_emisor){
        $url_timbrado = WSDL_URL;
        $user_id = FM_USER;
        $user_password = FM_KEY;
        $debug = DEBUG;
        $parametros = array('emisorRFC' => $rfc_emisor,'UserID' => $user_id,'UserPass' => $user_password);
        $cliente = new FacturacionModerna($url_timbrado, $parametros, $debug);
        return $cliente;
    }

    function timbrar(){

        $request = Slim::getInstance()->request();
        $data = json_decode($request->getBody());

        $rfc_emisor = $data->rfc;

        $numero_certificado = "20001000000200000192";
        $archivo_cer = "utilerias/certificados/20001000000200000192.cer";
        $archivo_pem = "utilerias/certificados/20001000000200000192.key.pem";

        $comprobante = $data->comprobante;
        
        $cfdi = $comprobante;
        $cfdi = sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem);
        
        $opciones = array();
        $opciones['generarCBB'] = false;
        $opciones['generarPDF'] = false;
        $opciones['generarTXT'] = false;
          
        $cliente = acceder($rfc_emisor);

        if($cliente->timbrar($cfdi, $opciones)){

            // $comprobante = 'comprobantes/'.$cliente->UUID;

            $result = array(
                'response'  =>  'success', 
                'object'    =>  array(
                                    'uuid'  => $cliente->UUID, 
                                    'xml'   => $cliente->xml,
                                    'rfc'   => $cliente->opciones['emisorRFC']
                                )
                );
            
            echo json_encode($result);
            
        }else{
            
            $result = array('response' => 'error', 'Description' => $cliente->ultimoError);
            echo json_encode($result);
        
        }    
    }

    function is_valid_xml($xml) {
        
        libxml_use_internal_errors( true );
        
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->load($xml) or die("XML invalido");
        $errors = libxml_get_errors();
        
        return empty( $errors );
    
    }

    function sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem){
        $private = openssl_pkey_get_private(file_get_contents($archivo_pem));
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($archivo_cer)));
          
        $xdoc = new DOMDocument();
        $xdoc->loadXML($cfdi) or die("XML invalido");

        $XSL = new DOMDocument();
        $XSL->load('utilerias/xslt32/cadenaoriginal_3_2.xslt');

        $proc = new XSLTProcessor;
        $proc->importStyleSheet($XSL);

        $cadena_original = $proc->transformToXML($xdoc);    
        openssl_sign($cadena_original, $sig, $private);
        $sello = base64_encode($sig);

        $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
        $c->setAttribute('sello', $sello);
        $c->setAttribute('certificado', $certificado);
        $c->setAttribute('noCertificado', $numero_certificado);
        
        return $xdoc->saveXML();

    }

    function cancelar(){

        $request = Slim::getInstance()->request();
        $data = json_decode($request->getBody());

        $rfc_emisor = $data->rfc;
        $cliente = acceder($rfc_emisor);

        $uuid = $data->uuid;
        $opciones=null;
          
        if($cliente->cancelar($uuid, $opciones)){
            $result = array('response' => 'success', 'Description' => 'Cancelacion exitosa');
            echo $result;
        }else{
            $result = array('response' => 'error', 'Description' => $cliente->ultimoError);
            echo json_encode($result);
        }    

    }

?>