<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatOfertas extends JModelList
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
            ->select('o.id, o.titulo, o.subtitulo, o.enlace, 
                c.nombre as categoria, o.path, o.orden, o.estado')
            ->from('#__ofertas o')
            ->join('LEFT', $db->quoteName('#__categoria', 'c') 
                . ' ON (' . $db->quoteName('o.id_categoria') . ' = ' . $db->quoteName('c.id') . ')') 
            ->order($field . ' '. $order);

            return $query;
	}
}
