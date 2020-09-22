<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
class CatPromocionalControllerCatProveedor extends JControllerForm
{
    public function save($key = null, $urlVar = null)
    {        
        $input = JFactory::getApplication()->input;
        $app = JFactory::getApplication();
        $form = $input->get('jform', '', 'array');
        $model = $this->getModel('catproveedor');
        if ($form['id'] == 0) $form['id'] = 1;
        if ($model->extProveedor($form['id']) == 0)
        {
            $model->addProveedor($form);           
            $app->redirect(JRoute::_(
                'index.php?option=com_catpromocional&view=catproveedors', false));
        }
        else {
            parent::save();
        }
    }  
    /*
     * Permite cambiar si el proveedor está activo.
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
        $model = $this->getModel('catproveedor'); 
        $model->setValue($id,$pb);         
        // Redirecciona a vista inicial.
        $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catproveedors', false));
    }
}