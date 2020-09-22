<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_catpromocional
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

/**
 * Quotation model for the Joomla CatPromocional component.
 *
 * @since  1.5
 */
class CatpromocionalModelQuotation extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // Create Quotation
    ////////////////////////////////////////////////////////////////////////////
    public function createQuotation($sesQuotation,$arrform,$modelqp,$modeldb)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Get user
        $user = JFactory::getUser();
        // Insert columns.
        $columns = array('id_usuario','nombre_cliente','email_cliente','comentario',
            'led_id','reemplazar_lead','id_primera_fuente','id_canal',
            'fecha_primera_fuente','fecha','valor_total','id_estado_cotizacion');
        // Insert values.
        $values = array($user->id, $db->quote($arrform['name']), $db->quote($arrform['email']), 
            $db->quote($arrform['nota']), (int)$arrform['tled'], 
            $db->quote($arrform['rlead']), (int)$arrform['pfuente'],
            (int)$arrform['pcanal'], $db->quote(date("Y-m-d",strtotime($arrform['fpfuente']))),'NOW()',0,1);
        // generate Register.
        $id = $modeldb->createRecord($db,$columns, $values, '#__cotizacion');
        // generate Quotation Item
        $this->createQuotationItem($id,$sesQuotation,$modelqp,$modeldb);        
        // return Id Quotation.
        return $id;
    }
    ////////////////////////////////////////////////////////////////////////////
    // Create Quotation Item
    ////////////////////////////////////////////////////////////////////////////
    public function createQuotationItem($id,$sesQuotation,$modelqp,$modeldb)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Insert columns.
        $columns = array('id_cotizacion','id_producto','cantidad','valor');
        // Validate exist Items.
        if (count($sesQuotation) > 0) {
            // Loop Items Session
            foreach ($sesQuotation as $qitem) {
                // Get product price.
                $price = $modelqp->getProductPrice($qitem['idproduct'],$qitem['cntproduct']);
                // Insert values.
                $values = array($id,$qitem['idproduct'],$qitem['cntproduct'],$price);
                // generate Register.
                $idi = $modeldb->createRecord($db, $columns, $values, '#__cotizacion_item');
                // Logos Register.
                $this->createQuotationItemLogo($idi,$qitem['idproduct'],
                    $qitem['cntproduct'],$qitem['logo'],$modelqp,$modeldb);
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // Create Quotation Item Logo
    ////////////////////////////////////////////////////////////////////////////
    public function createQuotationItemLogo($idqitem,$idproduct,$quantity,$logos,$modelqp,$modeldb)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Insert columns.
        $columns = array('id_cotizacion_item','logo','id_tecnica',
            'id_unidad','valor_tecnica');
        // Validate exist Logos.
        if (count($logos) > 0) {
            // Loop Item Logos
            foreach($logos as $logo) {
                // Get Value logos By Technique.
                $tprice = $modelqp->getTechniquePrice(
                        $idproduct,$logo['tecnica'],$logo['unidad'],$quantity);
                // Insert values.
                $values = array($idqitem, $db->quote($logo['nombre']), 
                    $logo['tecnica'], $logo['unidad'], $tprice);
                // generate Register.
                $idi = $modeldb->createRecord($db, $columns, $values, '#__cotizacion_item_logo');
                // Set Value Fixed Cost By Technique.
                $modelqp->setTotalFixedCostByTechnique($idi, $logo['tecnica'], $quantity, $tprice);            
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // Create Quotation Item CF
    ////////////////////////////////////////////////////////////////////////////
    public function createQuotationItemCF($idqiteml,$idcosto,$value,$idtprecio,$idtcosto,$modeldb)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Insert columns.
        $columns = array('id_cotizacion_item_logo','id_costofijo',
            'valor_costofijo','id_tipo_precio','id_tipo_costofijo');
        // Insert values.
        $values = array($idqiteml,$idcosto,$value,$idtprecio,$idtcosto);
        // generate Register.
        $modeldb->createRecord($db, $columns, $values, '#__cotizacion_item_costofijo');  
    }    
    ////////////////////////////////////////////////////////////////////////////
    // Clear Session
    ////////////////////////////////////////////////////////////////////////////
    public function clearSession() {
        // Get Session Joomla.
        $session = JFactory::getSession();
        // Clear Session vars.
        $session->clear('addproduct');
        $session->clear('crtproduct');
        $session->clear('quotation_id');
        $session->clear('quotation_cordig');
        $session->clear('quotation_coruser');
    }
}