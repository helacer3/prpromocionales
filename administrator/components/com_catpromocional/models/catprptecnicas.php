<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatPrpTecnicas extends JModelList
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
            ->select(array('ptp.id','p.nombre AS producto','t.nombre AS tecnica','u.nombre AS unidad', 
                'er.rango_inicial','er.rango_final','tp.nombre AS tipo_precio','ptp.valor','ptp.estado'))
            ->from($db->quoteName('#__producto_tecnica_precio', 'ptp'))  
            
            ->join('LEFT', $db->quoteName('#__producto_tecnica', 'pt') 
                . ' ON (' . $db->quoteName('ptp.id_producto_tecnica') . ' = ' . $db->quoteName('pt.id') . ')') 
            
            ->join('LEFT', $db->quoteName('#__unidad', 'u') 
                . ' ON (' . $db->quoteName('ptp.id_unidad') . ' = ' . $db->quoteName('u.id') . ')')
            
            ->join('LEFT', $db->quoteName('#__tipo_precio', 'tp') 
                . ' ON (' . $db->quoteName('ptp.id_tipo_precio') . ' = ' . $db->quoteName('tp.id') . ')') 
                                
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('ptp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')
                    
            ->join('LEFT', $db->quoteName('#__producto', 'p') 
                . ' ON (' . $db->quoteName('pt.id_producto') . ' = ' . $db->quoteName('p.id') . ')')
                    
            ->join('LEFT', $db->quoteName('#__tecnica', 't') 
                . ' ON (' . $db->quoteName('pt.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
                    
            ->order($field . ' '. $order);

            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "p.nombre like '%" .$filtro."%' OR ".
                    "t.nombre like '%" .$filtro."%' OR ".
                    "u.nombre like '%" .$filtro."%' "
                );
            } 
            
            return $query;
	}
}
