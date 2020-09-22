<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * CatPromocionals Controller
 */
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
class CatPromocionalControllerCatOfertas extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'CatPromocional', $prefix = 'CatPromocionalModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    /*
     * Permite cambiar si la oferta está publicada.
     */
    public function chInfo() {
            // Cargo metodos.
            $jinput = JFactory::getApplication()->input;
            $app = JFactory::getApplication();
            // Obtengo parametros get
            $id = $jinput->get('id', '0', 'int');
            $pb = $jinput->get('pb', '1', 'int');
            $tp = $jinput->get('tp', '1', 'int');
            //echo $id."-".$pb;exit;   
            // Obtengo el model.
            $model = $this->getModel('catoferta'); 
            $model->setValue($id,$pb,$tp);         
            // Redirecciona a vista inicial.
            $app->redirect(JRoute::_('index.php?option=com_catpromocional&view=catofertas', false));
        }
}