<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCprecio extends JControllerForm
{
    /******************************************************************************/
    // override Method Save.
    /******************************************************************************/
    public function save($data = array(), $key = 'id')
    {
        // set Vars.
        $jinput = JFactory::getApplication()->input;
        $files = $jinput->files->get('jform');
        $file = $files['prices_file'];
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
        $model = $this->getModel('Catcprecio');
        // Delete Prices Temporal.
        $model->truncateTable($db,"#__producto_precio_temporal");
        // Delete Prices.
        $model->truncateTable($db,"#__producto_precio");
        // Iterate file.
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10 - Este es
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;
            // Iterate rows
            for ($row = 2; $row <= $highestRow; ++ $row) {
                //validate Whether Exist.
                if (trim($worksheet->getCellByColumnAndRow(0, $row)) != "") {
                	// Create array.
                    $arrData = array();
                    // Loop cols.
                    $arrData = $this->getArrayRow($db,$model,$worksheet,$highestColumnIndex,$row);
                    //echo "<br /><pre>".var_dump($arrData)."</pre><br />";exit;
                    // set Product DB - temporal table.
                    $model->insertTemporalPrices($db,$arrData);
                }
                
            }
        }         
        // set Product DB - prices table.
        $model->insertPrices($db); 
        // return.
        return true;
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
                    $infoProduct = $model->getInfoProductUpload($db,trim($val));
                    $arrData['id_producto'] = (int)$infoProduct->id;
                    break;
                case 1:
                    $arrData['rango_inicial'] = $val;
                    break;
                case 2:
                    $arrData['rango_final'] = $val;
                    break;
                case 3:
                    $arrData['valor'] = $val;
                    break;
                default:
                    break;
            }
        }
        // Return Array col.
        return $arrData;
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
        $url = JRoute::_('index.php?option=com_catpromocional&view=catprecios',false);
        $app->redirect($url);
    }
    /******************************************************************************/
    // generate Prices File
    /******************************************************************************/
    public function generatePricesFile() {
        // PHP Excel
        include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel.php');
        // Indice inicial.
        $ind = 1;
        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Get Model Catcproducto.
        $model = $this->getModel('Catcprecio');
        // Establecer propiedades
        $objPHPExcel->getProperties()
        ->setCreator("Prpromocionales")
        ->setLastModifiedBy("Prpromocionales")
        ->setTitle("Precios Productos ProyectaT")
        ->setSubject("Excel cargador ProyectaT")
        ->setDescription("Excel cargador ProyectaT")
        ->setKeywords("Excel Office 2007");
        // Consulto la información de los precios de los productos.
        $prices = $model->getPricesList();
        // Set Columns Title
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, 'product_sku')
            ->setCellValue('B'.$ind, 'ran_ini')
            ->setCellValue('C'.$ind, 'ran_fin')
            ->setCellValue('D'.$ind, 'valor');
        // Loop Prices List
        foreach($prices as $price) {
            $ind++;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, $price->sku)
            ->setCellValue('B'.$ind, $price->rango_inicial)
            ->setCellValue('C'.$ind, $price->rango_final)
            ->setCellValue('D'.$ind, $price->valor);
        }
        // Renombrar Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Precios Productos');
        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $objPHPExcel->setActiveSheetIndex(0);
        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="preciosPrpromocionales'.date("Ymd_His").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}