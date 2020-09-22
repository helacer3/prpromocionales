<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatEscalas extends JModelList
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
        // Select some fields from the scale table.
        $query
            ->select('e.id,e.nombre,te.nombre AS nombre_tipo,e.estado')
            ->from($db->quoteName('#__escala', 'e'))
            ->join('LEFT', $db->quoteName('#__tipo_escala', 'te') 
                . ' ON (' . $db->quoteName('e.id_tipo_escala') . ' = ' . $db->quoteName('te.id') . ')')
            ->order($field . ' ' . $order);
        return $query;
	}
    ////////////////////////////////////////////////////////////////////////
    // get Scale Categories
    ////////////////////////////////////////////////////////////////////////
    public function getScaleCategories($id) {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id','c.nombre'))
            ->from($db->quoteName('#__escala_categoria','ec'))
            ->join('LEFT', $db->quoteName('#__categoria', 'c') 
                . ' ON (' . $db->quoteName('ec.id_categoria') . ' = ' . $db->quoteName('c.id') . ')')
            ->where($db->quoteName('ec.id_escala') ." = ".(int)$id)
            ->order($db->quoteName('c.nombre') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
}
