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
 * Products model for the Joomla Banners component.
 *
 * @since  1.5
 */
class CatpromocionalModelPromocional extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // Get Technique name
    ////////////////////////////////////////////////////////////////////////////
    public function getTechniqueName($idtechnique)
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('t.nombre'))
            ->from($db->quoteName('#__tecnica', 't'))            
            ->where($db->quoteName('t.id') ." = ". $db->quote($idtechnique));
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Unit name
    ////////////////////////////////////////////////////////////////////////////
    public function getUnitName($idUnit)
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('CONCAT(u.cantidad,\' \',u.nombre)'))
            ->from($db->quoteName('#__unidad', 'u'))            
            ->where($db->quoteName('u.id') ." = ". $db->quote($idUnit));
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Source First 
    ////////////////////////////////////////////////////////////////////////////
    public function getSourceFirst()
    {       
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('pf.id','pf.nombre'))
            ->from($db->quoteName('#__primera_fuente', 'pf'))
            ->order($db->quoteName('pf.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadAssocList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Led Type List
    ////////////////////////////////////////////////////////////////////////////
    public function getLedTypeList()
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('tl.id','tl.nombre'))
            ->from($db->quoteName('#__tipo_lead', 'tl'))
            ->order($db->quoteName('tl.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadAssocList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Channel List
    ////////////////////////////////////////////////////////////////////////////
    public function getChannelList()
    {       
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id','c.nombre'))
            ->from($db->quoteName('#__canal', 'c'))
            ->order($db->quoteName('c.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadAssocList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Search Phrase register
    ////////////////////////////////////////////////////////////////////////////
    public function searchPhraseRegister($wrdSearch,$modeldb){
        // Validate Word
        if (trim($wrdSearch) != "") {
            // Get a db connection.
            $db = JFactory::getDbo();
            // Get user
            $user = JFactory::getUser();
            // Insert columns.
            $columns = array('string_busqueda','id_user','ip_user','fecha');
            // Insert values.
            $values = array($db->quote($wrdSearch),$user->id,
                $db->quote($this->getRealIP()),'NOW()');
            // generate Register.
            $id = $modeldb->createRecord($db,$columns, $values, '#__busqueda');
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Real IP
    ////////////////////////////////////////////////////////////////////////////
    public function getRealIP() {
        switch(true){
            case (!empty($_SERVER['HTTP_X_REAL_IP'])) : 
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])) : 
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : 
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default : 
                return $_SERVER['REMOTE_ADDR'];
        }
    }
}
