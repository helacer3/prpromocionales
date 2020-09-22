<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatAsgCostos extends JModelList
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
            ->select(array('tcp.id','t.nombre AS tecnica','cf.nombre AS nombre_costo',
                'er.rango_inicial','er.rango_final','tc.nombre AS tipo_costo',
                'tp.nombre AS tipo_precio','tcp.valor','tcp.estado'))
            ->from($db->quoteName('#__tecnica_costofijo_precio', 'tcp'))  
            
            ->join('LEFT', $db->quoteName('#__tecnica_costofijo', 'tcf') 
                . ' ON (' . $db->quoteName('tcp.id_tecnica_costofijo') . ' = ' . $db->quoteName('tcf.id') . ')') 
            
            ->join('LEFT', $db->quoteName('#__tipo_costofijo', 'tc') 
                . ' ON (' . $db->quoteName('tcp.id_tipo_costofijo') . ' = ' . $db->quoteName('tc.id') . ')')

            
            ->join('LEFT', $db->quoteName('#__tipo_precio', 'tp') 
                . ' ON (' . $db->quoteName('tcp.id_tipo_precio') . ' = ' . $db->quoteName('tp.id') . ')') 
                                
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('tcp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')
                    
            ->join('LEFT', $db->quoteName('#__tecnica', 't') 
                . ' ON (' . $db->quoteName('tcf.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
                    
            ->join('LEFT', $db->quoteName('#__costofijo', 'cf') 
                . ' ON (' . $db->quoteName('tcf.id_costofijo') . ' = ' . $db->quoteName('cf.id') . ')')
                    
            ->order($field . ' ' . $order);

            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "t.nombre like '%" .$filtro."%' OR ".
                    "cf.nombre like '%" .$filtro."%' "
                );
            } 

            return $query;
	}
}
