<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatCostos extends JModelList
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
		// Select some fields from the costos table
		$query
		    ->select('cf.id, cf.nombre, cf.cnt_excluye, cf.estado, e.nombre as escala')
		    ->from('#__costofijo cf')
            ->join('LEFT', $db->quoteName('#__escala', 'e') 
            . ' ON (' . $db->quoteName('cf.id_escala') . ' = ' . $db->quoteName('e.id') . ')')
            ->order($field . ' ' . $order);
		return $query;
	}
}
