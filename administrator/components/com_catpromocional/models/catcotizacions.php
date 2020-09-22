<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatCotizacions extends JModelList
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
            $filtro     = trim($jinput->get('tx_prdfiltro', '', 'string'));
            $filtrofini = trim($jinput->get('tx_prdfecini', '', 'string'));
            $filtroffin = trim($jinput->get('tx_prdfecfin', '', 'string'));
            // Create a new query object.	
            $db = JFactory::getDBO();
            $query = $db->getQuery(true)
            ->select(array('c.id', 'u.id AS user_id', 'u.NAME AS nombre','u.email',
            'c.comentario','c.email_cliente','tl.nombre as tipo_lead','c.fecha',
            '(SELECT profile_value AS company FROM prp_user_profiles 
                WHERE profile_key=\'profile.company\' AND user_id = u.id) AS company',
            'c.id_estado_cotizacion'))
            ->from($db->quoteName('#__cotizacion', 'c'))            
            ->join('LEFT', $db->quoteName('#__users', 'u') 
                . ' ON (' . $db->quoteName('c.id_usuario') . ' = ' . $db->quoteName('u.id') . ')')            
            ->join('LEFT', $db->quoteName('#__tipo_lead', 'tl') 
                . ' ON (' . $db->quoteName('c.led_id') . ' = ' . $db->quoteName('tl.id') . ')')
            ->order($field .' '. $order);            
            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->where(
                    " (u.name like '%" .$filtro."%' OR ".
                    " c.email_cliente like '%" .$filtro."%' OR ".
                    " c.comentario like '%" .$filtro."%') ");
            }

            // Agrego el filtro fecha si es necesario
            if(trim($filtrofini) != "" && trim($filtroffin) != "") {
                $query->where(
                    " (DATE(fecha) >= '".$filtrofini."' AND DATE(fecha) <= '".$filtroffin."') "
                );
            }
            //echo "<br />".$query; exit;
            return $query;
	}
    /**
     * Method for getQuotationStates.
     * @since   2.5
     */
    public function getQuotationStates() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'nombre', 'imagen')))
            ->from($db->quoteName('#__estado_cotizacion'))
            ->where($db->quoteName('estado') . ' = 1')
            ->order('id ASC');  
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}
