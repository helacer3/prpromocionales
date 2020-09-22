<?php
/**
* @package Joomla.Administrator
* @subpackage com_catpromocional
*
* @copyright Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
 
// No direct access to this file
defined('_JEXEC') or die;
 
// import Joomla controller library
jimport('joomla.application.component.controller');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
require_once 'kint/Kint.class.php';
/**
 * CatPromocional Component Controller
 *
 * @since   0.0.1
 */
class CatPromocionalControllerQuotation extends JControllerLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // generate Quotation
    ////////////////////////////////////////////////////////////////////////////
    public function generateQuotation() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $productid = $input->getCmd('productid',0);
        $form = $input->getVar('form');
        parse_str($form, $formArray);
        $model = $this->getModel('products');
        $productInfo = $model->getProductSingleInfo($productid);
        $sesProducts = $this->addProductSession($productid,$productInfo,$formArray);
        // Get View
        $view = $this->getView('productocotizado','html');
        $view->assignRef('productid',$productid);
        $view->assignRef('productname',$productInfo['nombre']);
        $view->assignRef('sesproducts',$sesProducts);
        $view->display();
    }
    
}