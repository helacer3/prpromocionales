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
// jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT . '/controller.php';
require_once JPATH_COMPONENT . '/kint/Kint.class.php';
/**
 * CatPromocional Component Controller
 *
 * @since   0.0.1
 */
class CatPromocionalControllerProductfilters extends CatPromocionalController
{
    ////////////////////////////////////////////////////////////////////////////
    // get Product Filters.
    ////////////////////////////////////////////////////////////////////////////
    public function getProductFilters() {
        $input      = JFactory::getApplication()->input;
        $valini     = (float)str_replace(array(",","."),"",$input->getString('flt_valini',0));
        $valfin     = (float)str_replace(array(",","."),"",$input->getString('flt_valfin',0));
        $cntlogos   = $input->getInt('flt_cntlogos',0);
        $cntprods   = (float)str_replace(".","",$input->getString('flt_cntproducts',0));
        $idcategory = $input->getInt('flt_categories',0);
        $arrtecnica = $input->get('flt_tecnica', array(), 'ARRAY');
        $arrunidad  = $input->get('flt_unidad', array(), 'ARRAY');
        //echo "aca ".$valini." - ".$valfin." - ".$cntlogos." - ".$cntprods." - ".count($arrtecnica);exit;
        $this->getProductsFiltersOK($idcategory,$cntprods,$arrtecnica,$arrunidad,$valini,$valfin);
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Products Filters OK.
    ////////////////////////////////////////////////////////////////////////////
    public function getProductsFiltersOK($idcategory,$cntprods,$arrtecnica,$arrunidad,$valini,$valfin) {
        $arrProducts = array();
        $model       = $this->getModel('generals');
        $modelp      = $this->getModel('products');
        $modelqp     = $this->getModel('quotationprices');
        $products    = $model->getProductsByCategory($idcategory);
        // Loop Products
        foreach ($products as $product) {
            $genPrice    = 0;
            $unitPrice   = 0;
            // get product Techniques.
            $arrptecnicas = $model->getTechniquesProduct($product->id_producto,$arrtecnica);
            // get Product Price.
            $genPrice += $modelqp->getProductPrice($product->id_producto,$cntprods);
            //echo "<br />Conteos ".count($arrptecnicas)." = ".count(array_unique ($arrtecnica));
            // Validate techniques.
            if (count($arrptecnicas) == count(array_unique ($arrtecnica))) {
                // Loop Techniques.
                foreach ($arrtecnica as $key => $idTechnique) {
                    $genPrice += $modelqp->getTechniquePrice($product->id_producto,
                        $idTechnique,$arrunidad[$key],$cntprods);
                }
            }
            // Validate Price Calculated.
            if ($genPrice > 0) 
                $unitPrice = $genPrice / $cntprods;
            //echo "<br /> Precios ".number_format($unitPrice,0). " - " .$valini. " - " .$valfin;
            // Validate Price in Range.
            if (($valini <= $unitPrice) && ($valfin >= $unitPrice)) {
                // Generate array final.
                $arrProducts[] = (int)$product->id_producto;
                // Create Session
                $this->setFilterSession($arrProducts);
            }
        }
        // get Action Principal Controller.
        $catpromocional = new CatPromocionalController;
        $catpromocional->getproducts($arrProducts);
    }
    ////////////////////////////////////////////////////////////////////////////
    // setFilterSession
    ////////////////////////////////////////////////////////////////////////////
    public function setFilterSession($arrProducts) {
        $_SESSION['flt_products'] = $arrProducts;
    }
}