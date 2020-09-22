<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatCategorias extends JModelList
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
		$query->select('jc.id, jc.nombre, jc.descripcion,
			jcp.nombre AS cat_padre, jc.estado AS estado')
            ->from('#__categoria jc')
            ->join('LEFT', $db->quoteName('#__categoria', 'jcp')
                . ' ON (' . $db->quoteName('jc.categoria_padre') . ' = ' .$db->quoteName('jcp.id') . ')')
            ->join('LEFT', $db->quoteName('#__estado', 'je')
                . ' ON (' . $db->quoteName('jc.estado') . ' = ' .$db->quoteName('je.id') . ')');            
		return $query;
	}
    /*
    * get List Query SQL
    */
    public function getListQuerySQL($pd=0)
	{
        $jinput = JFactory::getApplication()->input;
        // Obtengo parametros de ordenamiento.
        $field = $jinput->get('c', '1', 'integer');
        $order = $jinput->get('ord', 'ASC', 'string');
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the categoria table
		$query->select('jc.id,jc.nombre,
                SUBSTRING(jc.descripcion,1,250) AS descripcion,
                jc.categoria_padre,IFNULL(jcp.nombre,\'\') AS cat_padre,
                jc.estado AS estado')
            ->from('#__categoria jc')
            ->join('LEFT', $db->quoteName('#__categoria', 'jcp')
                . ' ON (' . $db->quoteName('jc.categoria_padre') . ' = ' .$db->quoteName('jcp.id') . ')')
            ->join('LEFT', $db->quoteName('#__estado', 'je')
                . ' ON (' . $db->quoteName('jc.estado') . ' = ' .$db->quoteName('je.id') . ')')
            ->where($db->quoteName('jc.categoria_padre') ." = ".(int)$pd)
			->order($field ." ". $order);

		//echo $query; exit;

        $db->setQuery($query);
		return $db->loadObjectList();
	}
}
