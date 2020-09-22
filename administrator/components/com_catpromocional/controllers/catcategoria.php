<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCategoria extends JControllerForm
{
    public function postSaveHook($model, $validData)
    {
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        $item = $model->getItem();
        $id = $item->get('id');
        $jinput = JFactory::getApplication()->input;
        $post  = $jinput->post->get('jform', array(), 'array');
        //var_dump($post);exit;
        // Valido si se parametrizó imágen principal.
        if ($post['imagen_1'] != "") {    
            // Relaciono imágenes productos.
            $model->saveProductImages($id,$post['imagen_1']);
        }
    }
    /*
     * Permite cambiar si la categoria esta activa.
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
        $model = $this->getModel('catcategoria'); 
        $model->setValue($id,$pb);         
        // Redirecciona a vista inicial.
        $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catcategorias', false));
    }
    
}