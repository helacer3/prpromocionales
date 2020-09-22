<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatPromocionals extends JModelList
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
            // Select some fields from the producto table
            $query->select('a.id,a.nombre,a.descripcion,
            a.especificaciones,a.sku,
            a.referencia,a.destacado,
            a.publicado,a.estado,
            b.nombre as proveedor,
            (SELECT IFNULL(MIN(valor),0) FROM #__producto_precio 
                WHERE id_producto = a.id) AS precio,
            (SELECT GROUP_CONCAT(f.nombre)  
                FROM #__producto_categoria e
                INNER JOIN #__categoria f
                ON e.id_categoria = f.id
                WHERE e.id_producto=a.id) AS categorias');
            $query->from('#__producto a');
            $query->join('LEFT', $db->quoteName('#__proveedor', 'b')
                . ' ON (' . $db->quoteName('a.id_proveedor') . ' = ' .$db->quoteName('b.id') . ')');
            // Agrego el filtro si es necesario
            if(trim($filtro) != "") {
                $query->having(
                    "a.nombre like '%" .$filtro."%' OR ".
                    "b.nombre like '%" .$filtro."%' OR ".
                    "categorias like '%" .$filtro."%' "
                );
            }
            $query->order($field ." ". $order);
            //echo $query;
            return $query;
	}
}
