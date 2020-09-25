<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

ini_set('max_execution_time', 500);
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/services/RestService.php');
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/services/GeneralFunctions.php');

/**
 * CatPromocionals Controller
 */
class CatPromocionalControllerCatProviderMarpico extends JControllerAdmin
{
	//class Vars
	var $urlService  = "marpicoprod.azurewebsites.net/api/inventarios";
    var $arrHeaders  = array ('Content-Type' => 'application/json; charset=utf-8');
	var $crlOptions  = array (
        CURLOPT_HTTPHEADER => array (
            'Accept:application/json',
            'Authorization: Api-Key 3cVkp1Kto5FfIIwbNZ51unGTU3jGlT9F92WF56mVMglLv73KuZsLXtghY62gsmTq'
        )
    );

    /*
    * get Products
    * http://localhost/proyectat/administrator/index.php?option=com_catpromocional&task=CatProviderMarpico.getProducts
    */
    public function getProducts():array {
        // create Default Vars
        $arrProducts = array();
        try {
            // instance Rest Service
            $srvRest  = new RestService;
            // call Service Product
            $arrResult = $srvRest->genericRestClient(
                $this->urlService, 
                "materialesAPI", 
                "GET", 
                array (
                    'page'      => 1,
                    'page_size' => 1
                ), 
                $this->arrHeaders,
                $this->crlOptions,
                $dscService = "Obtener el listado pagina de productos de Marpico"
            );
            // validate Result
            if (GeneralFunctions::validateIndexExist($arrResult, 'status') == "OK") {
                // load Array Products
                $arrProducts = GeneralFunctions::validateIndexExist($arrResult, 'result', 'results');
            } 
            echo "<pre><b>".count($arrProducts)."</b>"; print_r($arrProducts); echo "</pre>"; die;
        } catch(\Exception $ex){
            echo "error: ".$ex->getMessage();die;
        }
        // default Return
        return $arrProducts;
    }

	/*
	* get Product By Id
    * http://localhost/proyectat/administrator/index.php?option=com_catpromocional&task=CatProviderMarpico.getProductById
	*/
	public function getProductById():array {
        // create Default Vars
        $arrProduct = array();
        $idProduct  = 'BO0013';
        try {
            // instance Rest Service
            $srvRest  = new RestService;
            // call Service Product
            $arrProduct = $srvRest->genericRestClient(
                $this->urlService, 
                "materialesAPIByProducto", 
                "GET", 
                array (
                    'producto' => $idProduct
                ), 
                $this->arrHeaders,
                $this->crlOptions,
                $dscService = "Obtener la información de un producto de Marpico por SKU"
            );
            echo "<pre>"; print_r($arrProduct); echo "</pre>"; die;
        } catch(\Exception $ex){
            echo "error: ".$ex->getMessage();die;
        }
		// default Return
		return $arrProduct;
	}


}	