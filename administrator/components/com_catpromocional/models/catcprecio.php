<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatCprecio extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	2.5
	 */
	public function getTable($type = 'Dominio', $prefix = 'CatPromocionalTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	2.5
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_catpromocional.catcprecio', 'catcprecio',
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
    /**
     * Method get Info Product Upload.
     *
     * @return  array with ID AND Scale Product
     * @since   2.5
     */
    public function getInfoProductUpload($db,$sku) {
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'id_escala')))
            ->from($db->quoteName('#__producto'))
            ->where($db->quoteName('sku') . ' = '. $db->quote($sku));
        $db->setQuery($query);
        return $db->loadObject();
    }
    /**
     * Method to create Product.
     *
     * @return	
     * @since	2.5
     */
    public function insertTemporalPrices($db,$arrData) {
        // Create a new query object.
        $query = $db->getQuery(true);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__producto_precio_temporal'))
            ->columns($db->quoteName(array_keys($arrData)))
            ->values(implode(',', $arrData));
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;
        $db->execute();
    }
    /**
     * Method to insert Prices.
     *
     * @return  
     * @since   2.5
     */
    public function insertPrices($db) {
        $query = "INSERT INTO #__producto_precio 
            (id_producto,id_escala_rangos,valor,id_tipo_precio,fecha) 
            SELECT 
            p.id AS id_producto, 
            er.id AS id_escala_rango, 
            ppt.valor AS valor, 
            2 AS tipo_precio, 
            NOW() AS fecha 
            FROM #__producto_precio_temporal ppt
            LEFT JOIN #__producto p
            ON ppt.id_producto = p.id
            LEFT JOIN #__escala_rangos er
            ON p.id_escala = er.id_escala
            WHERE ppt.rango_inicial = er.rango_inicial 
            AND ppt.rango_final = er.rango_final
            ORDER BY ppt.id_producto ASC, er.id ASC";
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;
        $db->execute();
    }
    /**
     * Method to truncate table sent as a parameter.
     *
     * @return	
     * @since	2.5
     */
    public function truncateTable($db,$table) {
        $db->truncateTable($table);
        $db->execute();
    }    
    /**
     * Method to get Prices List.
     *
     * @return  
     * @since   2.5
     */
    public function getPricesList() {
        // Create a new query object.       
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // query
        $query
            ->select(
                array(
                    'DISTINCT p.id',
                    'p.sku',
                    'er.rango_inicial',
                    'er.rango_final',
                    'pp.valor'
                )
            )
            ->from($db->quoteName('#__producto','p'))
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('p.id_escala') . ' = ' . $db->quoteName('er.id_escala') . ')')
            ->join(
                'LEFT', $db->quoteName('#__producto_precio', 'pp') 
                . ' ON (' . $db->quoteName('pp.id_escala_rangos') . ' = ' . $db->quoteName('er.id')
                . ' AND ' . $db->quoteName('pp.id_producto') . ' = ' . $db->quoteName('p.id') . ')'
            )
            ->order($db->quoteName('p.id') . ' ASC')
            ->order($db->quoteName('er.rango_inicial') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
}