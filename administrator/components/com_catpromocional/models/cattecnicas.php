<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatTecnicas extends JModelList
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
		    ->select('t.id, e.nombre as escala, t.descripcion, t.descripcion_unidad, 
    			t.nombre, t.nombre_frontend, tb.nombre AS tecnica_padre, t.estado')
		    ->from('#__tecnica t')
            ->join('LEFT', $db->quoteName('#__escala', 'e')
                . ' ON (' . $db->quoteName('t.id_escala') . ' = ' .$db->quoteName('e.id') . ')')            
            ->join('LEFT', $db->quoteName('#__tecnica', 'tb')
                . ' ON (' . $db->quoteName('t.id_tecnica') . ' = ' .$db->quoteName('tb.id') . ')')
            ->order($field .' '.$order);
        //echo $query; exit;
		return $query;
	}
}