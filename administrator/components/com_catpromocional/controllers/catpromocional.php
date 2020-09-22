<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * CatPromocional Controller
 */
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
class CatPromocionalControllerCatPromocional extends JControllerForm
{    
    public function postSaveHook($model, $validData)
    {
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        //$model->fec_creacion = date("Y-m-d H:i:s");
        //$model->fec_ultmodifica = date("Y-m-d H:i:s");
        //$model->save();
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        $item = $model->getItem();
        $id = $item->get('id');
        $imagenes = array();
        $jinput = JFactory::getApplication()->input;
        $post  = $jinput->post->get('jform', array(), 'array');
        //var_dump($post);exit;
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // Recibo las variables.
        $imagenes[1] = $post['imagen_1'];
        $imagenes[2] = $post['imagen_2'];
        $imagenes[3] = $post['imagen_3'];
        $imagenes[4] = $post['imagen_4'];
        // Valido si se parametrizó imágen principal.
        if ($imagenes[1] != "") {    
            // Relaciono imágenes productos.
            $model->saveProductImages($id,$imagenes);
        }
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // Relaciono categorias de producto
        $model->saveProductCategories($id,$post['categorias']);  
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // Relaciono paises de producto
        $model->saveProductCountries($id,$post['paises']);  
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // Productos Relacionados.
        $model->saveRelationedProducts($id,$post['productos_relacionados']);
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // Técnicas Relacionadas.
        $model->saveRelationedTechniques($id,$post['tecnicas']);                  
        ////////////////////////////////////////////////////////
    }
}