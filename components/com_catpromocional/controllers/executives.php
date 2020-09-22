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
//jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT . '/controller.php';

require_once JPATH_COMPONENT. '/kint/Kint.class.php';
/**
 * CatPromocional Component Controller
 *
 * @since   0.0.1
 */
class CatPromocionalControllerExecutives extends CatPromocionalController
{
    ////////////////////////////////////////////////////////////////////////////
    // change Prices Product.
    ////////////////////////////////////////////////////////////////////////////
    public function changePricesProduct() {
        $input = JFactory::getApplication()->input;
        $productid = $input->getCmd('id',0);
        $productranges = $input->get('price_range', array(), 'ARRAY');
        //echo "<pre>".var_dump($productid)."</pre><br />";exit;
        $user = JFactory::getUser();
        // Validate is Executive
        if (in_array(10, $user->groups)) {
            // Get Model           
            $modelqp = $this->getModel('quotationprices');
            // Loop Product Ranges.
            foreach($productranges as $id_rescale => $valor) {
                $modelqp->setPriceRangeScaleProduct($productid,$id_rescale,$valor);
            }
        }        
        // Set Message.
        $msg = 'Los precios del producto se ajustaron correctamente.'; 
        // Redirect Home Products
        $this->redirectHomeProducts($productid,2,$msg);

    }
    ////////////////////////////////////////////////////////////////////////////
    // Disable Product
    ////////////////////////////////////////////////////////////////////////////
    public function disableProduct() {
        // Get Id
        $input = JFactory::getApplication()->input;
        $productid = $input->getCmd('id',0);
        $v = $input->getCmd('v',0);
        $est = $input->getCmd('est',2);
        $user = JFactory::getUser();
        // Validate is Executive
        if (in_array(10, $user->groups)) {
            //echo "/index.php/productos/disableProduct/34343?view=executives";exit;
            $model = $this->getModel('products');
            $model->setDisableProduct($productid,$est);
        }        
        // Set Message.
        $msg = 'El estado del producto se cambió correctamente.'; 
        // Redirect Home Products
        $this->redirectHomeProducts($productid,$v,$msg);
    }
    ////////////////////////////////////////////////////////////////////////////
    // Redirect Home Products
    ////////////////////////////////////////////////////////////////////////////
    public function redirectHomeProducts($id,$v,$msg) {
        $app  = JFactory::getApplication();
        // Validate redirect destination.
        if ($v == 2)
            $link = JRoute::_('index.php?option=com_catpromocional&task=getProduct&id='.(int)$id);
        else
            $link = JRoute::_('index.php?option=com_catpromocional&task=getProducts');
        // Redirect.
        $app->redirect($link, $msg, $msgType='message');
    }
    ////////////////////////////////////////////////////////////////////////////
    // set View Product
    ////////////////////////////////////////////////////////////////////////////
    public function setViewProduct() {
        $input = JFactory::getApplication()->input;
        $linkid = $input->get('id', '', 'string');
        $lidvalues = explode("_", $linkid);
        $model = $this->getModel('products');
        $user = JFactory::getUser();
        $model->setViewProductInfo($lidvalues[1],$user->id);
    }
}