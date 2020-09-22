<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatLimcotizas extends JModelList
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
            $query = $db->getQuery(true);
            // Select fields
            $query
                ->select(array('lc.id','u.email as usuario','u.name as nombre',
                'cl.nombre AS categoria','lc.cantidad_actual','lc.cantidad_total','lc.estado',
                '(SELECT profile_value FROM prp_user_profiles WHERE '
                    . 'user_id = u.id AND profile_key=\'profile.company\' limit 1) as empresa'))
                ->from($db->quoteName('#__limita_cotizaciones','lc'))                    
                ->join('LEFT', $db->quoteName('#__users', 'u')
                . ' ON (' . $db->quoteName('lc.id_usuario') . ' = ' .$db->quoteName('u.id') . ')')                    
                ->join('LEFT', $db->quoteName('#__categoria_limita', 'cl')
                . ' ON (' . $db->quoteName('lc.id_categoria_limita') . ' = ' .$db->quoteName('cl.id') . ')')
                ->order($field. ' ' .$order);

            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "u.name like '%" .$filtro."%' OR ".
                    "u.email like '%" .$filtro."%' OR ".
                    "empresa like '%" .$filtro."%' OR ".
                    "cl.nombre like '%" .$filtro."%' "
                );
            } 
            return $query;
	}
}
