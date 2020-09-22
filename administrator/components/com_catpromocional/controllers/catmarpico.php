<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

ini_set('max_execution_time', 500);
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/restclient.php');
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel/IOFactory.php');

/**
 * CatPromocionals Controller
 */
class CatPromocionalControllerCatMarpico extends JControllerAdmin
{

	//class Vars
	var $urlService  = "https://www.mppromocionales.com/ws_products.php/.json/.json";
	var $accessToken = "c8486d7170b3f4ad886741d94e252c7cf253079a36d832bd56a11e08931a27ef";
	
	/*
	* get Products
	*/
	public function getProducts() {
        // empty Array
        $arrProducts = array();
        try {
    		// create API
    		$api = new RestClient([
    			'base_url' => $this->urlService, 
    			'format' => "json",
    		]);
    		// result
    		$result = $api->get("", ['token' => $this->accessToken]);
            //echo"<pre>";var_dump($result->decode_response());echo"</pre>";die;
    		if($result->info->http_code == 200) {
                // set Service Response
    			$arrProducts = $result->decode_response();
    		}
        } catch(\Exception $ex){
            //echo "error: ".$ex->getMessage();die;
        }
		// default Return
		return $arrProducts;
	}


	/*
	* get Catalogue
	*/
    public function getCatalogue() {
        try {
            // Indice inicial.
            $ind = 1;
        	// Products List
    		$listProducts = $this->getProducts();
    		//echo "HELLO<br /><pre>"; var_dump($listProducts); echo "</pre>"; die;
            // PHP Excel
            include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel.php');
            // Crea un nuevo objeto PHPExcel
            $objPHPExcel = new PHPExcel();
            // Get Model Catcproducto.
            $model = $this->getModel('Catccostecnica');
            // Establecer propiedades
            $objPHPExcel->getProperties()
            ->setCreator("Prpromocionales")
            ->setLastModifiedBy("Prpromocionales")
            ->setTitle("Productos Marpico")
            ->setSubject("Excel marpico ProyectaT")
            ->setDescription("Excel marpico ProyectaT")
            ->setKeywords("Excel Office 2007");
            // Consulto la información de los costos de las técnicas.
            $costecnicas = $model->getCostsTechniquesList();
            // Set Columns Title
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$ind, 'Referencia')
                ->setCellValue('B'.$ind, 'Código Producto')
                ->setCellValue('C'.$ind, 'Color')
                ->setCellValue('D'.$ind, 'Descripción')
                ->setCellValue('E'.$ind, 'Descripción Larga')
                ->setCellValue('F'.$ind, 'Material')
                ->setCellValue('G'.$ind, 'Empaque')
                ->setCellValue('H'.$ind, 'Área Impresión')
                ->setCellValue('I'.$ind, 'Medidas')
                ->setCellValue('J'.$ind, 'Marca')
                ->setCellValue('K'.$ind, 'Existencias')
                ->setCellValue('L'.$ind, 'En Transito 1')
                ->setCellValue('M'.$ind, 'En Transito 2') 
                ->setCellValue('N'.$ind, 'En Transito 3') 
                ->setCellValue('O'.$ind, 'En Transito 4') 
                ->setCellValue('P'.$ind, 'En Transito 5') 
                ->setCellValue('Q'.$ind, 'Valor Unitario')
                ->setCellValue('R'.$ind, 'Categoría');
            // Loop Products
            foreach($listProducts as $listProduct) {
                $ind++;
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$ind, $listProduct->referencia)
                ->setCellValue('B'.$ind, $listProduct->codigoProd)
                ->setCellValue('C'.$ind, $listProduct->color)
                ->setCellValue('D'.$ind, $listProduct->descripcion)
                ->setCellValue('E'.$ind, $listProduct->descLarga)
                ->setCellValue('F'.$ind, $listProduct->material)
                ->setCellValue('G'.$ind, $listProduct->empaque)
                ->setCellValue('H'.$ind, $listProduct->areaImpresion)
                ->setCellValue('I'.$ind, $listProduct->medidas)
                ->setCellValue('J'.$ind, $listProduct->marca)
                ->setCellValue('K'.$ind, $listProduct->existencias)
                ->setCellValue('L'.$ind, $listProduct->enTransito1) 
                ->setCellValue('M'.$ind, $listProduct->enTransito2) 
                ->setCellValue('N'.$ind, $listProduct->enTransito3) 
                ->setCellValue('O'.$ind, $listProduct->enTransito4) 
                ->setCellValue('P'.$ind, $listProduct->enTransito5) 
                ->setCellValue('Q'.$ind, $listProduct->vlrUnitario)
                ->setCellValue('R'.$ind, $listProduct->categoria);
            }
            // Renombrar Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Catálogo Marpico');
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);
            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="catalogoMarpico'.date("Ymd_His").'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }catch(\Exception $ex){
            echo "Error: ".$ex->getMessage();die;
        }
    }
}	