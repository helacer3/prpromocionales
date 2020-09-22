<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
jimport('joomla.filesystem.file');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCproducto extends JControllerForm
{
    /******************************************************************************/
    // override Method Save.
    /******************************************************************************/
    public function save($data = array(), $key = 'id')
    {
        // set Vars.
        $jinput = JFactory::getApplication()->input;
        $files = $jinput->files->get('jform');
        $file = $files['products_file'];
        $src = $file['tmp_name'];
        $filename = str_replace(" ","",JFile::makeSafe($file['name']));
        // Validate extension
        $this->validateExtension($filename);
        // Set Dest
        $dest = JPATH_SITE."/media/com_catpromocional/files/".$filename;
        if (JFile::upload($src, $dest)) {
            //echo "Vamos perfect ".$dest;exit;
            $this->readUploadedFile($dest);
            // Set message type.
            $mtype = 1;
        } else {
            // Set message type.
            $mtype = 2;
        }
        // Redirect To Product List.
        $this->redirectToReport($mtype);
    }
    /******************************************************************************/
    // read Upload File
    /******************************************************************************/
    private function readUploadedFile($file) {
    	include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel/IOFactory.php');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Get Model Catcproducto.
        $model = $this->getModel('Catcproducto');
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10 - Este es
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;
            // Iterate file.
            for ($row = 2; $row <= $highestRow; ++ $row) {
                //validate Whether Exist.
                if (trim($worksheet->getCellByColumnAndRow(0, $row)) != "") {
                	// Create array.
                    $arrData = array();
                    // Loop cols.
                    $arrData = $this->getArrayRow($db,$model,$worksheet,$highestColumnIndex,$row);
                    //echo "<br /><pre>".var_dump($arrData)."</pre><br />";exit;
                    // set Product DB.
                    $this->setProductDb($db,$model,$arrData);
                }                
            }
        }    	
    }
    /******************************************************************************/
    // get Array Row
    /******************************************************************************/
    private function getArrayRow($db,$model,$worksheet,$highestColumnIndex,$row) {
    	// Create array.
        $arrData = array();
        // Iterate cols.
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
            switch ($col) {
                case 0:
                    $arrData['id'] = (int)$val; 
                    break;
                case 1:
                    $arrData['sku'] = $db->quote($val);
                    $arrData['referencia'] = $db->quote($val);
                    break;
                case 2:
                    $arrData['descripcion'] = $db->quote($val);
                    break;
                case 3:
                    $arrData['especificaciones'] = $db->quote($val);
                    break;
                case 4:
                    $arrData['publicado'] = trim($val)=='Y'?1:2;
                    break;
                case 5:
                    $arrData['destacado'] = trim($val)=='Y'?1:2;
                    break;		
                case 6:
                    $arrData['nombre'] = $db->quote($val);
                    break;			
                case 7:
                    $arrData['id_proveedor'] = (int)$model->getProviderId(trim($val));
                    break;  		
                case 8:
                    $arrData['category_p'] = (int)$val;
                    break;   		
                case 9:
                    $arrData['category_s'] = (int)$val;
                    break;		
                case 10:
                    $arrData['id_modelo'] = (int)$model->getModelId(trim($val));
                    break;          
                case 11:
                    $arrData['cnt_minima'] = (int)$val;
                    break;   		
                case 12:
                    $arrData['id_escala'] = (int)$val;
                    break;  		
                case 13:
                    $arrData['estado'] = (int)$val;
                    break;            			
                default:
                    break;
            }
        }
        $arrData['fec_ultmodifica'] = 'NOW()';
        // Return Array col.
        return $arrData;
    }
    /******************************************************************************/
    // set Product Db
    // 1 = guardar
    // 2 = editar
    // 3 = desactivar
    // 4 = mantener estable
    /******************************************************************************/
    private function setProductDb($db,$model,$arrData) {
        //echo "entra".$arrData['estado']; exit;
        switch ((int)$arrData['estado']){
            case 1:
                $arrData['estado'] = 1;
                $arrData['fec_creacion'] = 'NOW()';
                $model->createProduct($db,$arrData);
                break;
            case 2:
                $arrData['estado'] = 1;
                $model->updateProduct($db,$arrData);
                break;
            case 3:
                $model->updateProduct(
                    $db, array(
                        'id' => $arrData['id'], 
                        'estado' => 2,
                        'fec_ultmodifica' => 'NOW()'
                    )
            	);
                break;
            default:
                break;                
        }
    }
    /******************************************************************************/
    // validate Extension
    /******************************************************************************/
    private function validateExtension($filename) {
        if(preg_match("/\.(xlsx)$/", $filename))
            return true;
        else
            $this->redirectToReport(3);
    }
    /******************************************************************************/
    // redirect To Form
    /******************************************************************************/
    private function redirectToReport($mtype) {
        // set Message.
        if ($mtype == 3)
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CATPROMOCIONAL_UPLOAD_FILE_ERROR_EXTENSION'), 'error');
        else if ($mtype == 2)
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CATPROMOCIONAL_UPLOAD_FILE_ERROR'), 'error');
        else
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CATPROMOCIONAL_UPLOAD_FILE_SUCCESS'), 'message');
        // redirect
        $app = JFactory::getApplication();
        $url = JRoute::_('index.php?option=com_catpromocional&view=catpromocionals',false);
        $app->redirect($url);
    }
    /******************************************************************************/
    // generate Products File
    /******************************************************************************/
    public function generateProductsFile() {
        // PHP Excel
        include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel.php');
        // Indice inicial.
        $ind = 1;
        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Get Model Catcproducto.
        $model = $this->getModel('Catcproducto');
        // Establecer propiedades
        $objPHPExcel->getProperties()
        ->setCreator("Prpromocionales")
        ->setLastModifiedBy("Prpromocionales")
        ->setTitle("Productos ProyectaT")
        ->setSubject("Excel cargador ProyectaT")
        ->setDescription("Excel cargador ProyectaT")
        ->setKeywords("Excel Office 2007");
        // Consulto la informacion de los productos.
        $products = $model->getProductsList();
        // Set Columns Title
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, 'product_id')
            ->setCellValue('B'.$ind, 'product_sku')
            ->setCellValue('C'.$ind, 'product_special')
            ->setCellValue('D'.$ind, 'product_name')
            ->setCellValue('E'.$ind, 'proveedor')
            ->setCellValue('F'.$ind, 'cat.Principal')
            ->setCellValue('G'.$ind, 'cat.Secundaria')
            ->setCellValue('H'.$ind, 'TSL')
            ->setCellValue('I'.$ind, 'Restricción')
            ->setCellValue('J'.$ind, 'id_escala')
            ->setCellValue('K'.$ind, 'estado');        
        // Loop ProductsList
        foreach($products as $product) {
            $ind++;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, $product->id)
            ->setCellValue('B'.$ind, $product->sku)
            ->setCellValue('C'.$ind, $product->destacado)
            ->setCellValue('D'.$ind, $product->nombre)
            ->setCellValue('E'.$ind, $product->proveedor)
            ->setCellValue('F'.$ind, $product->cat_principal)
            ->setCellValue('G'.$ind, $product->cat_secundaria)
            ->setCellValue('H'.$ind, $product->modelo)
            ->setCellValue('I'.$ind, $product->restriccion)
            ->setCellValue('J'.$ind, $product->id_escala)
            ->setCellValue('K'.$ind, $product->estado);
        }
        // Renombrar Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Productos');
        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $objPHPExcel->setActiveSheetIndex(0);
        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="productosPrpromocionales'.date("Ymd_His").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}