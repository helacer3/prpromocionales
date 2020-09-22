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
 * Quotationprices model for the Joomla CatPromocional component.
 *
 * @since  1.5
 */
class CatpromocionalModelQuotationprices extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // get Prices Ranges Scale Product
    ////////////////////////////////////////////////////////////////////////////
    public function getPricesRangesScaleProduct($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('er.id','er.rango_inicial','er.rango_final','pp.valor'))
            ->from($db->quoteName('#__producto_precio', 'pp'))  
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('pp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')  
            ->where($db->quoteName('pp.id_producto') ." = ". (int)$id)
            ->where($db->quoteName('er.estado') ." = 1");
        //echo "<br />aca ".$query;
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadObjectList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Scale Product Range
    ////////////////////////////////////////////////////////////////////////////
    public function getScaleProductRange($id,$quantity)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('er.id'))
            ->from($db->quoteName('#__producto', 'p'))  
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('p.id_escala') . ' = ' . $db->quoteName('er.id_escala') . ')')  
            ->where($db->quoteName('p.id') ." = ". (int)$id)
            ->where(
                $db->quoteName('er.rango_inicial') ." <= ". (int)$quantity
                ." AND ".$db->quoteName('er.rango_final') ." >= ". (int)$quantity
            )
            ->setLimit(1);
        //echo "<br />aca ".$query;
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Price Scale Product Range
    ////////////////////////////////////////////////////////////////////////////
    public function getPriceScaleProductRange($id,$quantity,$idRangeScale) {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('valor','id_tipo_precio'))
            ->from($db->quoteName('#__producto_precio'))
            ->where($db->quoteName('id_producto') ." = ". (int)$id)
            ->where($db->quoteName('id_escala_rangos') ." = ". (int)$idRangeScale)
            ->setLimit(1);
        //echo "<br />aca ".$query;
        // Prepare the query
        $db->setQuery($query);
        // get result Query.
        $sqlResult =  $db->loadAssoc();
        // Validate result.
        if (count($sqlResult) > 0) {
            if ($sqlResult['id_tipo_precio'] == 2) {
                return $sqlResult['valor'] * $quantity;
            } else {
                return $sqlResult['valor'];
            }
        }
        // Default return.
        return 0;
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Product Price
    ////////////////////////////////////////////////////////////////////////////
    public function getProductPrice($id,$quantity)
    {
        // Get Range Scale.
        $idRangeScale = $this->getScaleProductRange($id, $quantity);
        // Get Price Range Scale.
        return $this->getPriceScaleProductRange($id, $quantity, $idRangeScale);
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Technique Price
    ////////////////////////////////////////////////////////////////////////////
    public function getTechniquePrice($idproduct,$idtechnique,$idunidad,$quantity)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('pp.valor','pp.id_tipo_precio'))
            ->from($db->quoteName('#__producto_tecnica', 'pt'))  
            ->join('LEFT', $db->quoteName('#__producto_tecnica_precio', 'pp') 
                . ' ON (' . $db->quoteName('pt.id') . ' = ' . $db->quoteName('pp.id_producto_tecnica') . ')')
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('pp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')    
            ->where($db->quoteName('pp.id_unidad') . ' = ' .(int)$idunidad)
            ->where($db->quoteName('pt.id_producto') . ' = ' .(int)$idproduct)
            ->where($db->quoteName('pt.id_tecnica') . ' = ' .(int)$idtechnique)
            ->where($db->quoteName('er.estado') ." = 1")
            ->where(
                $db->quoteName('er.rango_inicial') ." <= ". (int)$quantity
                ." AND ".$db->quoteName('er.rango_final') ." >= ". (int)$quantity);
        //echo "<br />aca ".$query; exit;
        // Prepare the query
        $db->setQuery($query);
        // Get result
        $sqlResult = $db->loadAssoc();
        // Validate result
        if (count($sqlResult) > 0) {
            if ($sqlResult['id_tipo_precio'] == 2) {
                return $sqlResult['valor'] * $quantity;
            } else {
                return $sqlResult['valor'];                
            }
        }
        // Default return.
        return 0;
    }
    ////////////////////////////////////////////////////////////////////////////
    // get List Fixed Cost By Technique
    ////////////////////////////////////////////////////////////////////////////
    public function getListFixedCostByTechnique($id,$quantity) {        
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id AS idcosto','tcp.valor','tcp.id_tipo_costofijo','tcp.id_tipo_precio'))
            ->from($db->quoteName('#__costofijo', 'c'))  
            ->join('INNER', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('c.id_escala') . ' = ' . $db->quoteName('er.id_escala') . ')') 
            ->join('INNER', $db->quoteName('#__tecnica_costofijo', 'tc') 
                . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('tc.id_costofijo') . ')')
            ->join('INNER', $db->quoteName('#__tecnica_costofijo_precio', 'tcp') 
                . ' ON (' . $db->quoteName('tc.id') . ' = ' . $db->quoteName('tcp.id_tecnica_costofijo') 
                . ' AND ' . $db->quoteName('tcp.id_escala_rangos') . ' = '.$db->quoteName('er.id').')')    
            ->where($db->quoteName('tc.id_tecnica') . ' = ' .(int)$id)
            ->where($db->quoteName('c.estado') ." = 1")
            ->where($db->quoteName('er.estado') ." = 1")
            ->where(
                "(".$db->quoteName('c.cnt_excluye') ." > ".(int)$quantity
                ." OR ".$db->quoteName('c.cnt_excluye') ." = 0 )"
            )
            ->where(
                "(".$db->quoteName('er.rango_inicial') ." <= ". (int)$quantity
                ." AND ".$db->quoteName('er.rango_final') ." >= ". (int)$quantity." )"
            );
        //echo "<br /><br />aca ".$query;exit;
        // Prepare the query
        $db->setQuery($query);
        // return Result.
        return $db->loadAssocList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // set List Fixed Cost By Technique
    ////////////////////////////////////////////////////////////////////////////
    public function setTotalFixedCostByTechnique($idqiteml, $idtechnique, $cantity, $prcTechnique) {
        // Get Model.
        $modelq = $this->getInstance('quotation', 'CatpromocionalModel');
        $modeldb = $this->getInstance('dbmethods', 'CatpromocionalModel');
        // get List Cost By Technique.
        $arrCost = $this->getListFixedCostByTechnique($idtechnique, $cantity);
        //echo "<pre>";var_dump($arrCost);echo "</pre><br />";exit;
        // Loop By Technique
        foreach ($arrCost as $cost) {
            // Validate Tipo Costo
            if ($cost['id_tipo_costofijo'] == 1) { // Valor
                if ($cost['id_tipo_precio'] == 1) { // Total
                    $value = $cost['valor'];
                } else {// Unidad
                    $value = $cost['valor']*$cantity;
                }
            } else { // Porcentaje
                $value = $this->getPercentage($prcTechnique,$cost['valor']);
            }
            // Register Fixed Cost Quotation.
            $modelq->createQuotationItemCF($idqiteml,$cost['idcosto'],$value,
                $cost['id_tipo_precio'],$cost['id_tipo_costofijo'],$modeldb);
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // set Price Range Scale Product
    ////////////////////////////////////////////////////////////////////////////
    public function setPriceRangeScaleProduct($productid,$rescalaid,$value)
    {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);
        // Fields to update.
        $fields = array(
            $db->quoteName('valor') . ' = '.$this->removeThousandsSeparators($value),
            $db->quoteName('fecha') . ' = NOW()'
        );
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id_producto') . ' = ' .(int)$productid,
            $db->quoteName('id_escala_rangos') . ' = ' .(int)$rescalaid,
        );
        $query->update($db->quoteName('#__producto_precio'))->set($fields)->where($conditions);
        //echo "<br >".$query;exit;
        $db->setQuery($query);
        $db->execute();         
    }
    ////////////////////////////////////////////////////////////////////////////
    // remove Thousands Separators
    ////////////////////////////////////////////////////////////////////////////
    public function removeThousandsSeparators($valor) {
        return (int)str_replace(array('.'), "", $valor);
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Percentage
    ////////////////////////////////////////////////////////////////////////////
    public function getPercentage($precio,$percentage) {
        return ($precio*$percentage)/100;
    }
}