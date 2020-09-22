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
class CatPromocionalModelCatCcosto extends JModelAdmin
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
	public function getTable($type = 'Imagenes', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.Catccosto', 'catccosto',
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
            ->insert($db->quoteName('#__producto_costo_temporal'))
            ->columns($db->quoteName(array_keys($arrData)))
            ->values(implode(',', $arrData));
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;
        $db->execute();
    }
    /**
     * Method to insert Costs.
     *
     * @return  
     * @since   2.5
     */
    public function insertPrices($db) {
        $query = "INSERT INTO #__producto_costo
            (id_producto,id_escala_rangos,valor,fecha) 
            SELECT 
            p.id AS id_producto, 
            er.id AS id_escala_rango, 
            pct.valor AS valor,
            NOW() AS fecha 
            FROM #__producto_costo_temporal pct
            LEFT JOIN #__producto p
            ON pct.id_producto = p.id
            LEFT JOIN #__escala_rangos er
            ON p.id_escala = er.id_escala
            WHERE pct.rango_inicial = er.rango_inicial 
            AND pct.rango_final = er.rango_final
            ORDER BY pct.id_producto ASC, er.id ASC";
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
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
}