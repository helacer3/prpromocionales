<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
jimport('joomla.filesystem.file');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCcotizacions extends JControllerForm
{
    /******************************************************************************/
    // set Order State
    /******************************************************************************/
    public function setOrderState() {
        // Recibo info.
        $jinput = JFactory::getApplication()->input;
        // Obtengo valores
        $val     = $jinput->get('val', '', 'integer');
        $id      = trim($jinput->get('id', '', 'string'));
        $idParts = explode("_", $id);
        // Get Model Catccotizacion.
        $model = $this->getModel('Catccotizacion');
        // set State
        $model->setState($idParts[2],$val);
    }
    /******************************************************************************/
    // generate Orders File
    /******************************************************************************/
    public function generateOrdersFile() {
        // Recibo info.
        $jinput = JFactory::getApplication()->input;
        // Obtengo filtros
        $filtrotexto = trim($jinput->get('texto', '', 'string'));
        $filtrofini  = trim($jinput->get('fecini', '', 'string'));
        $filtroffin  = trim($jinput->get('fecfin', '', 'string'));
        // PHP Excelstate
        include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/PHPExcel.php');
        // Indice inicial.
        $ind = 1;
        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Get Model Catccotizacion.
        $model = $this->getModel('Catccotizacion');
        // Establecer propiedades
        $objPHPExcel->getProperties()
        ->setCreator("Prpromocionales")
        ->setLastModifiedBy("Prpromocionales")
        ->setTitle("Ordenes ProyectaT")
        ->setSubject("Excel ordenes ProyectaT")
        ->setDescription("Excel ordenes ProyectaT")
        ->setKeywords("Excel Office 2007");
        // Consulto la informacion de las ordenes.
        $orders = $model->getOrdersList(
            $filtrotexto, $filtrofini, $filtroffin);
        // Set Columns Title
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, 'id_orden')
            ->setCellValue('B'.$ind, 'id_usuario')
            ->setCellValue('C'.$ind, 'fecha')
            ->setCellValue('D'.$ind, 'email_usuario')
            ->setCellValue('E'.$ind, 'nombre_usuario')
            ->setCellValue('F'.$ind, 'compañia_usuario')
            ->setCellValue('G'.$ind, 'sector_usuario')
            ->setCellValue('H'.$ind, 'pais_usuario')
            ->setCellValue('I'.$ind, 'ciudad_usuario')
            ->setCellValue('J'.$ind, 'telefono_usuario')
            ->setCellValue('K'.$ind, 'movil_usuario')
			
			->setCellValue('L'.$ind, 'nombre_cliente')
            ->setCellValue('M'.$ind, 'email_cliente')
            ->setCellValue('N'.$ind, 'empresa_cliente')
            ->setCellValue('O'.$ind, 'ciudad_cliente')
            ->setCellValue('P'.$ind, 'telefono_cliente')
			->setCellValue('Q'.$ind, 'canal_cliente')
			->setCellValue('R'.$ind, 'comentario_cliente')
            ->setCellValue('S'.$ind, 'estado_cotizacion');        
        // Loop ProductsList
        foreach($orders as $order) {
            $ind++;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ind, $order->id)
            ->setCellValue('B'.$ind, $order->user_id)
            ->setCellValue('C'.$ind, $order->fecha)
            ->setCellValue('D'.$ind, $order->nombre_usuario)
            ->setCellValue('E'.$ind, $order->email_usuario)
            ->setCellValue('F'.$ind, $order->compania_usuario)
            ->setCellValue('G'.$ind, $order->sector_usuario)
            ->setCellValue('H'.$ind, $order->pais_usuario)
            ->setCellValue('I'.$ind, $order->ciudad_usuario)
            ->setCellValue('J'.$ind, $order->telefono_usuario)
            ->setCellValue('K'.$ind, $order->movil_usuario)
			
            ->setCellValue('L'.$ind, $order->nombre_cliente)
            ->setCellValue('M'.$ind, $order->email_cliente)
            ->setCellValue('N'.$ind, $order->empresa)
            ->setCellValue('O'.$ind, $order->nombre_ciudad)
            ->setCellValue('P'.$ind, $order->telefono)
			->setCellValue('Q'.$ind, $order->nombre_canal)
			->setCellValue('R'.$ind, $order->comentario)
            ->setCellValue('S'.$ind, $order->nombre_estado_cotizacion);
        }
        // Renombrar Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Ordenes');
        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $objPHPExcel->setActiveSheetIndex(0);
        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ordenesPrpromocionales'.date("Ymd_His").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}