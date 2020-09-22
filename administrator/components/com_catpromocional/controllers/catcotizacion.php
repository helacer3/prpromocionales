<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL); 
// import Joomla controller library
jimport('joomla.application.component.controller');
// get model CnsCotizacions
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once JPATH_COMPONENT_SITE.DS.'models'.DS.'cnsquotation.php';
require_once JPATH_COMPONENT_SITE.DS.'models'.DS.'products.php';
/**
 * CatPromocional Controller
 */
class CatPromocionalControllerCatCotizacion extends JControllerForm

{
    public function show()
    {
        $input = JFactory::getApplication()->input;
        $id = $input->getCmd('id','0');
        $view = $this->getView('catcotizacion','html');
        $model = $this->getModel('cnsquotation');
        $modelp = $this->getModel('products');
        $modelcq = $this->getModel('cnsquotation');
        $quotation = $model->getQuotation($id);
        $qitem = $model->getQuotationItems($id);
        $view->assignRef('id',$id);
        $view->assignRef('model',$model);
        $view->assignRef('modelp',$modelp);
        $view->assignRef('modelcq',$modelcq);
        $view->assignRef('quotation',$quotation);
        $view->assignRef('qitem',$qitem);
        $view->display();
    }
}