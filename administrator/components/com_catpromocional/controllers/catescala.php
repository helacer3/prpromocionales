<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatEscala extends JControllerForm
{
    public function postSaveHook($model, $validData)
    {
        // Get Item.
        $item = $model->getItem();
        // Get Id.
        $id = $item->get('id');
        // Asigno escala a categorías asignadas
        $model->saveScaleCategories($id,$_POST['jform']['categorias']); 
    }
    /*
     * Permite cambiar si la escala está activo.
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
        $model = $this->getModel('catescala'); 
        $model->setValue($id,$pb);         
        // Redirecciona a vista inicial.
        $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catescalas', false));
    }
}