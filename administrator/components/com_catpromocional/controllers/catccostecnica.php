<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCcostecnica extends JControllerForm
{
    /******************************************************************************/
    // override Method Save.
    /******************************************************************************/
    public function save($data = array(), $key = 'id')
    {
        // set Vars.
        $jinput = JFactory::getApplication()->input;
        $files = $jinput->files->get('jform');
        $file = $files['costecnicas_file'];
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
        $model = $this->getModel('Catccostecnica');
        // truncate table Product Cost Technique Tsl
        $model->truncateTable($db,"#__producto_tecnica_costo_tsl");
        $model->truncateTable($db,"#__producto_tecnica_costo");
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
                    // insert Product Cost Technique Tsl
                    $model->insertProductTechniqueCostTsl($db,$arrData);
                }
                
            }
        }
        // Insert Product Cost Technique.
        $model->insertProductTechniqueCost($db);
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
            switch ((int)$col) {
                case 0:
                    $arrData['id_modelo'] = (int)$model->getModelId($val);
                    break;
                case 1:
                    $arrData['rango_inicial'] = $db->quote($val);
                    break;
                case 2:
                    $arrData['rango_final'] = $db->quote($val);
                    break;
                case 3:
                    $arrData['valor'] = $val;
                    break;
                case 4:
                    $arrData['cnt_unidad'] = (int)$val;
                    break;
                case 5:
                    $arrData['id_unidad'] = (int)$val;
                    break;
                case 6:
                    $arrData['id_tecnica'] = (int)$val;
                    ///$arrData['id_unidad'] = (int)$model->getUnitId(
                    //    $arrData['id_unidad'],$arrData['id_tecnica']);
                    break;
                case 7:
                    $arrData['id_tipo_precio'] = (int)$val;
                    break;
                case 8:
                    $arrData['estado'] = (int)$val;
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
        $url = JRoute::_('index.php?option=com_catpromocional&view=catcostecnicas',false);
        $app->redirect($url);
    }
    /******************************************************************************/
    // generate Costs Techniques File
    /******************************************************************************/
    public function generateCostsTechniquesFile() {
        // PHP Excel
        include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel.php');
        // Indice inicial.
        $ind = 1;
        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Get Model Catcproducto.
        $model = $this->getModel('Catccostecnica');
        // Establecer propiedades
        $objPHPExcel->getProperties()
        ->setCreator("Prpromocionales")
        ->setLastModifiedBy("Prpromocionales")
        ->setTitle("Costos Técnicas ProyectaT")
        ->setSubject("Excel cargador ProyectaT")
        ->setDescription("Excel cargador ProyectaT")
        ->setKeywords("Excel Office 2007");
        // Consulto la información de los costos de las técnicas.
        $costecnicas = $model->getCostsTechniquesList();
        // Set Columns Title
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, 'Modelo_TSL')
            ->setCellValue('B'.$ind, 'cnt_minima')
            ->setCellValue('C'.$ind, 'cnt_maxima')
            ->setCellValue('D'.$ind, 'precio')
            ->setCellValue('E'.$ind, 'valor')
            ->setCellValue('F'.$ind, 'unidad_impresion')
            ->setCellValue('G'.$ind, 'cod_impresion_tipo')
            ->setCellValue('H'.$ind, 'id_tipo_precio')
            ->setCellValue('I'.$ind, 'estado');
        // Loop Costs List
        foreach($costecnicas as $costecnica) {
            $ind++;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, $costecnica->modelo)
            ->setCellValue('B'.$ind, $costecnica->rango_inicial)
            ->setCellValue('C'.$ind, $costecnica->rango_final)
            ->setCellValue('D'.$ind, $costecnica->costo)
            ->setCellValue('E'.$ind, $costecnica->valor)
            ->setCellValue('F'.$ind, $costecnica->unidad_impresion)
            ->setCellValue('G'.$ind, $costecnica->id_tecnica)
            ->setCellValue('H'.$ind, $costecnica->id_tipo_precio)
            ->setCellValue('I'.$ind, $costecnica->estado);
        }
        // Renombrar Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Costos Técnicas');
        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $objPHPExcel->setActiveSheetIndex(0);
        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="costostslPrpromocionales'.date("Ymd_His").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}