<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatAsgCosto extends JControllerForm
{
    /*
     * Permite cambiar si la asignación de costo fijo está activa.
     */
    public function chInfo() {
        // Cargo metodos.
        $jinput = JFactory::getApplication()->input;
        $app = JFactory::getApplication();
        // Obtengo parametros get
        $id = $jinput->get('id', '0', 'int');
        $pb = $jinput->get('pb', '1', 'int');
        //echo $id."-".$pb;exit;   
        // Obtengo el model.
        $model = $this->getModel('catasgcosto'); 
        $model->setValue($id,$pb);         
        // Redirecciona a vista inicial.
        $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catasgcostos', false));
    }
    
    public function save(string $key = null, string $urlVar = null) {
        // Creo Array.
        $costoFijo = array();
        // Cargo metodos.
        $jinput = JFactory::getApplication()->input;
        // Get the form data 
        $formData = new JInput($jinput->get('jform', '', 'array')); 
        // Obtengo parametros post
        $costoFijo['id'] = $formData->getInt('id', 0);
        $costoFijo['id_tecnica'] = $formData->getInt('id_tecnica', 0);
        $costoFijo['id_costofijo'] = $formData->getInt('id_costofijo', 0);
        $costoFijo['id_escala'] = $formData->getInt('id_escala', 0);
        $costoFijo['id_escala_rango'] = $formData->getInt('id_escala_rango', 0);
        $costoFijo['id_tipo_costofijo'] = $formData->getInt('id_tipo_costofijo', 0);
        $costoFijo['id_tipo_precio'] = $formData->getInt('id_tipo_precio', 0);
        $costoFijo['valor'] = $formData->getInt('valor', 0);
        $costoFijo['estado'] = $formData->getFloat('estado', 0);
        // Obtengo el model.
        $model = $this->getModel('catasgcosto');
        // Guardo el costo fijo.
        $model->saveCostoFijoTecnica($costoFijo);
        // Redirect to Registers List.
        $mainframes = JFactory::getApplication();
        $link=  JRoute::_('index.php?option=com_catpromocional&view=catasgcostos',FALSE);
        $msg = JText::_('El elemento ha sido guardado correctamente.');
        $mainframes->redirect($link,$msg);
    }
}