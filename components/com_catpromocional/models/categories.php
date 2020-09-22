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
class CatpromocionalModelCategories extends JModelLegacy
{
    // Get Info Category.
    public function getInfoCategory($idcategory)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id', 'c.nombre', 'c.descripcion'))
            ->from($db->quoteName('#__categoria', 'c'))
            ->where($db->quoteName('c.id') ." = ". $db->quote($idcategory))
            ->where($db->quoteName('c.estado') ." = ". $db->quote(1))
            ->order($db->quoteName('c.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObject();
    }
    // Get image Element
    public function getImagesElement($idElemento,$tipoElemento)
    {        
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('path'))
            ->from($db->quoteName('#__imagenes'))
            ->where($db->quoteName('id_elemento') ." = ". $db->quote($idElemento))
            ->where($db->quoteName('id_tipo_elemento') ." = ". $db->quote($tipoElemento))
            ->where($db->quoteName('estado') ." = ". $db->quote(1))
            ->order($db->quoteName('id') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
    // get Id Category Url
    public static function getIdCategoryUrl($idcategory)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('CONCAT(id,\'_\',nombre)'))
            ->from($db->quoteName('#__categoria'))
            ->where($db->quoteName('id') ." = ". $db->quote($idcategory));
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadResult();
    }
}
