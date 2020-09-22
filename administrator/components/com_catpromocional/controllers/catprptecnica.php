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
class CatPromocionalControllerCatPrpTecnica extends JControllerForm
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
        $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catprptecnicas', false));
    }
}