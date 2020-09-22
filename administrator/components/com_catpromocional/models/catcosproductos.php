<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatCosproductos extends JModelList
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
            // Select some fields from the producto_costo table
            $query
                ->select('ppc.id, pe.nombre AS escala, ppc.id_producto, p.sku, 
                    ppc.valor, ppc.fecha, per.rango_inicial, per.rango_final ')
                ->from($db->quoteName('#__producto_costo','ppc'))
                ->join('LEFT', $db->quoteName('#__producto', 'p') 
                    . ' ON (' . $db->quoteName('ppc.id_producto') . ' = ' . $db->quoteName('p.id') . ')')
                ->join('LEFT', $db->quoteName('#__escala_rangos', 'per') 
                    . ' ON (' . $db->quoteName('ppc.id_escala_rangos') . ' = ' . $db->quoteName('per.id') . ')')
                ->join('LEFT', $db->quoteName('#__escala', 'pe') 
                    . ' ON (' . $db->quoteName('per.id_escala') . ' = ' . $db->quoteName('pe.id') . ')')
                ->order($field . ' ' . $order);

            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "p.sku like '%" .$filtro."%' OR ".
                    "pe.nombre like '%" .$filtro."%' "
                );
            } 
            //echo "<br />".$query;exit;
            return $query;
	}
}
