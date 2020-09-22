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
 * Generals model for the Joomla CatPromocional component.
 *
 * @since  1.5
 */
class CatpromocionalModelGenerals extends JModelLegacy
{
    ///////////////////////////////////////////////////////////////////////
    // Get Sectors
    ///////////////////////////////////////////////////////////////////////
    public function getSectors()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('s.id', 's.nombre'))
            ->from($db->quoteName('#__sector', 's'))
            ->where($db->quoteName('s.estado') ." = ". $db->quote(1))
            ->order($db->quoteName('s.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        //echo $query; exit;
        // Load Object List.
        return $db->loadObjectList();
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Country Name
    ///////////////////////////////////////////////////////////////////////
    public function getCountryName($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('p.nombre'))
            ->from($db->quoteName('#__pais', 'p'))
            ->where($db->quoteName('p.id') ." = ". (int)$id)
            ->where($db->quoteName('p.estado') ." = ". $db->quote(1));
        // Prepare the query
        $db->setQuery($query);
        //echo $query; exit;
        // Load Object List.
        return $db->loadResult();
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Countries
    ///////////////////////////////////////////////////////////////////////
    public function getCountries()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('p.id', 'p.nombre'))
            ->from($db->quoteName('#__pais', 'p'))
            ->where($db->quoteName('p.estado') ." = ". $db->quote(1))
            ->order($db->quoteName('p.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        //echo $query; exit;
        // Load Object List.
        return $db->loadObjectList();
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Cities
    ///////////////////////////////////////////////////////////////////////
    public function getCities()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id', 'c.nombre'))
            ->from($db->quoteName('#__ciudades', 'c'))
            ->where($db->quoteName('c.estado') ." = ". $db->quote(1))
            ->order($db->quoteName('c.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        //echo $query; exit;
        // Load Object List.
        return $db->loadObjectList();
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Products By Category
    ///////////////////////////////////////////////////////////////////////
    public function getProductsByCategory($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('pc.id_producto'))
            ->from($db->quoteName('#__producto_categoria', 'pc'))
            ->join('LEFT', $db->quoteName('#__producto', 'p') 
                . ' ON (' . $db->quoteName('pc.id_producto') . ' = ' . $db->quoteName('p.id') . ')')            
            ->where($db->quoteName('p.estado') ." = 1")
            ->order($db->quoteName('pc.id_producto') . ' ASC');

        // Validate Id filter.
        if ($id >0) {
            $query->where($db->quoteName('pc.id_categoria') ." = ". (int)$id);
        }
        // Prepare the query
        $db->setQuery($query);
        //echo $query; exit;
        // Load Object List.
        return $db->loadObjectList();
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Techniques Product 
    ///////////////////////////////////////////////////////////////////////
    public function getTechniquesProduct($id,$arrtecnica)
    {
        if (count($arrtecnica) > 0) {
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('id_tecnica'))
                ->from($db->quoteName('#__producto_tecnica'))
                ->where($db->quoteName('id_producto') ." = ". (int)$id);
            
                $query->where($db->quoteName('id_tecnica')." IN (".implode(",",$arrtecnica).")");
            // Prepare the query
            $db->setQuery($query);
            //echo $query; exit;
            // Load Object List.
            return $db->loadAssocList();
        } else {
            return array();
        }
    }
    ///////////////////////////////////////////////////////////////////////
    // Get Format String 
    ///////////////////////////////////////////////////////////////////////
    public static function getFormatString($string) {
        $decoded = utf8_decode($string);
        if (mb_detect_encoding($decoded , 'UTF-8', true) === false)
            return $string;
        else
            return $decoded;
    }
}
