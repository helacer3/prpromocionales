<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatPrecios extends JModelList
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
            // Obtengo parametros get
            $filtro = trim($jinput->get('tx_prdfiltro', '', 'string'));
            // Create a new query object.		
            $db = JFactory::getDBO();
            $query = $db->getQuery(true)
            ->select(array('pp.id, p.nombre AS producto','er.rango_inicial','er.rango_final',
                'e.nombre AS escala','pp.valor','tp.nombre AS tipo_precio'))
            ->from($db->quoteName('#__producto_precio', 'pp'))  
            
            ->join('LEFT', $db->quoteName('#__producto', 'p') 
                . ' ON (' . $db->quoteName('pp.id_producto') . ' = ' . $db->quoteName('p.id') . ')') 
            
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('pp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')
                    
            ->join('LEFT', $db->quoteName('#__escala', 'e') 
                . ' ON (' . $db->quoteName('er.id_escala') . ' = ' . $db->quoteName('e.id') . ')') 
                                
            ->join('LEFT', $db->quoteName('#__tipo_precio', 'tp') 
                . ' ON (' . $db->quoteName('pp.id_tipo_precio') . ' = ' . $db->quoteName('tp.id') . ')')
                    
            ->order($field .' '. $order);

            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "p.nombre like '%" .$filtro."%' OR ".
                    "e.nombre like '%" .$filtro."%' "
                );
            } 
            //echo "query : ".$query;
            return $query;
	}
}