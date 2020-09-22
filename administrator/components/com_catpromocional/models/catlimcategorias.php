<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
 
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatLimcategorias extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
            // Create a new query object.		
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            // Select some fields from the categoria table
            $query
                ->select('id,nombre,descripcion,cantidad')
                ->from($db->quoteName('#__categoria_limita'))
                ->order($db->quoteName('nombre') . ' ASC');
            return $query;
	}
}
