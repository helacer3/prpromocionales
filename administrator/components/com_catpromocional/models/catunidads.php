<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatUnidads extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
        $jinput = JFactory::getApplication()->input;
        // Obtengo parametros de ordenamiento.
        $field = $jinput->get('c', '1', 'integer');
        $order = $jinput->get('ord', 'ASC', 'string');
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the categoria table
		$query
		    ->select('u.id, u.cantidad, u.nombre, u.estado, t.nombre as tecnica')
		    ->from('#__unidad u')
            ->join('LEFT', $db->quoteName('#__tecnica', 't') 
            . ' ON (' . $db->quoteName('u.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
            ->order($field. ' ' .$order);
		return $query;
	}
}
