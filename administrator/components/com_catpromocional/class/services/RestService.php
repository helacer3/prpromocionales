<?php
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/restclient.php');
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/services/GeneralFunctions.php');

/**
* Rest Service
*/
class RestService {
    /**
     * generic Rest Client
     * @param  String $baseUrl     Url base del Servicio
     * @param  String $apiAction   Acción del servicio que se desea llamar
     * @param  String $typMethod   Tipo de solicitud (GET, POST, etc)
     * @param  Array  $lstParams   Arreglo con el listado de parámetros a enviar al servicio
     * @param  Array  $arrHeaders  Arreglo con las cabeceras requeridas para el servicio
     * @param  Array  $crlOptions  Arreglo con las configuración del CURL
     * @param  String $dscService  Descripción breve del servicio
     * @return Array  $arrResponse Arreglo con la respuesta del servicio
     * @author Snayder Acero <helacer3@yahoo.es>
    */
    public function genericRestClient($baseUrl, $apiAction, $typMethod, $lstParams, $arrHeaders, $crlOptions = array(CURLOPT_ENCODING => ''), $dscService = "")
    {
        // create Response Array
        $arrResponse = array (
            "status" => "ERROR",
            "result" => "Ocurrió un error al acceder a: ".$dscService
        );
        try {
            // call Rest Service.
            $apiInstance = new \RestClient([
                'base_url'     => $baseUrl,
                'curl_options' => $crlOptions
            ]);
            // Method Request
            $rstApi = $apiInstance->{$typMethod}($apiAction, $lstParams, $arrHeaders);
            // echo "<pre>";var_dump($rstApi);echo "</pre>";die;
            // validate response Code
            if (GeneralFunctions::validatePropertyExist($rstApi, 'info', 'http_code') == 200 || 
                GeneralFunctions::validatePropertyExist($rstApi, 'info', 'http_code') == 301) {
                // set Array Response
                $arrResponse = array (
                    "status" => "OK",
                    "result" => (array)$rstApi->decode_response()
                );
            } else {
                // decode Json Response
                $decResponse = json_decode(GeneralFunctions::validatePropertyExist($rstApi, 'response'));
                // set Array Response
                $arrResponse = array (
                    "status" => "ERROR",
                    "result" => GeneralFunctions::validatePropertyExist($decResponse, 'title')." - ".
                    GeneralFunctions::validatePropertyExist($decResponse, 'description')
                );
            }
        } catch (\Exception $ex) {
            // message Exception
            $msgException = "Error realizando el Request: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine();
            // set Array Response
            $arrResponse = array ("status" => "ERROR", "result" => $msgException);
        }
        // default Return
        return $arrResponse;   
    }
}