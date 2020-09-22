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
class CatPromocionalModelCatCprctecnica extends JModelAdmin
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
		$form = $this->loadForm('com_catpromocional.Catcprctecnica', 'catcprctecnica',
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
    /**
     * Method to insert Product Image.
     *
     * @return  
     * @since   2.5
     */
    public function insertProductImage($db,$arrData) {
       // Create a new query object.
        $query = $db->getQuery(true);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__imagenes'))
            ->columns($db->quoteName(array_keys($arrData)))
            ->values(implode(',', $arrData));
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
        $db->execute();
    }
    /**
     * Method to insert Product Technique Price Tsl.
     *
     * @return  
     * @since   2.5
     */
    public function insertProductTechniquePriceTsl($db,$arrData) {
       // Create a new query object.
        $query = $db->getQuery(true);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__producto_tecnica_precio_tsl'))
            ->columns($db->quoteName(array_keys($arrData)))
            ->values(implode(',', $arrData));
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
        $db->execute();
    }

    /**
     * Method to insert Product Technique.
     *
     * @return  
     * @since   2.5
     */
    public function insertProductTechnique($db) {
        // Create a new query.
        $query = "INSERT INTO 
            prp_producto_tecnica (id_producto,id_tecnica)
            SELECT DISTINCT b.id, a.id_tecnica 
            FROM prp_producto_tecnica_precio_tsl a
            INNER JOIN prp_producto b
            ON a.id_modelo = b.id_modelo";
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
        $db->execute();
    }
    /**
     * Method to insert Product Technique Price.
     *
     * @return  
     * @since   2.5
     */
    public function insertProductTechniquePRice($db) {
       // Create a new query.
        $query = "INSERT INTO prp_producto_tecnica_precio 
            (id_producto_tecnica,id_unidad,id_tipo_precio,
            id_escala_rangos,valor,fecha,estado)
            SELECT id_producto_tecnica,id_unidad,id_tipo_precio,
            id_escala_rangos,valor,NOW(),estado FROM
            (SELECT DISTINCT
            p.id AS id_producto, p.nombre, p.id_escala AS escala,
            pt.id AS id_producto_tecnica, pt.id_tecnica AS id_tecnica,
            u.id AS id_unidad, u.nombre AS unidad, u.cantidad AS cnt_unidad,
            e.id AS id_escala, er.id AS id_escala_rangos,
            p.id_modelo, ptpt.valor, ptpt.id_tipo_precio, ptpt.estado
            FROM prp_producto_tecnica_precio_tsl ptpt
            INNER JOIN prp_producto p
            ON ptpt.id_modelo = p.id_modelo
            INNER JOIN prp_producto_tecnica pt
            ON pt.id_producto = p.id
            INNER JOIN prp_unidad u
            ON pt.id_tecnica = u.id_tecnica
            INNER JOIN prp_tecnica t
            ON pt.id_tecnica = t.id
            INNER JOIN prp_escala e
            ON t.id_escala = e.id
            INNER JOIN prp_escala_rangos er
            ON er.id_escala = e.id
            WHERE ptpt.id_tecnica = pt.id_tecnica
            AND ptpt.id_unidad = u.id
            AND ptpt.cnt_unidad = u.cantidad
            AND ptpt.rango_inicial = er.rango_inicial
            AND ptpt.rango_final = er.rango_final
            ORDER BY p.id DESC) AS interna";
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
        $db->execute();
    }
    /**
     * Method to get the Id with the Model Name
     *
     * @return  Provider Id
     * @since   2.5
     */
    public function getModelId($name) {      
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id'))
            ->from($db->quoteName('#__modelo'))            
            ->where($db->quoteName('nombre') ." = ". $db->quote($name));
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    /**
     * Method to get the Id with the Unit Name
     *
     * @return  Unit Id
     * @since   2.5
     */
    public function getUnitId($name,$idtechnique) {      
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id'))
            ->from($db->quoteName('#__unidad'))            
            ->where('lower('.$db->quoteName('nombre').')' ." = ". 
                $db->quote(strtolower($name)))            
            ->where($db->quoteName('id_tecnica') ." = ". (int)$idtechnique);
        //echo "<br />".$query;exit;
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
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
     * Method to get Prices Techniques List.
     *
     * @return  
     * @since   2.5
     */
    public function getPricesTechniquesList() {
        // Create a new query object.       
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // query
        $query
            ->select(
                array(
                    'DISTINCT p.id_modelo',
                    'm.nombre as modelo',
                    't.id AS id_tecnica',
                    'u.id AS unidad_impresion',
                    'u.nombre AS unidad',
                    'u.cantidad AS valor',
                    'er.id AS escala_rango',
                    'er.rango_inicial',
                    'er.rango_final',
                    'ptp.valor AS precio',
                    'ptp.id_tipo_precio',
                    'ptp.estado'
                )
            )
            ->from($db->quoteName('#__producto','p'))
            ->join('LEFT', $db->quoteName('#__modelo', 'm') 
                . ' ON (' . $db->quoteName('p.id_modelo') . ' = ' . $db->quoteName('m.id') . ')')
            ->join('LEFT', $db->quoteName('#__producto_tecnica', 'pt') 
                . ' ON (' . $db->quoteName('pt.id_producto') . ' = ' . $db->quoteName('p.id') . ')')
            ->join('LEFT', $db->quoteName('#__tecnica', 't') 
                . ' ON (' . $db->quoteName('pt.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
            ->join('LEFT', $db->quoteName('#__unidad', 'u') 
                . ' ON (' . $db->quoteName('u.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
            ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('t.id_escala') . ' = ' . $db->quoteName('er.id_escala') . ')')
            ->join('LEFT', $db->quoteName('#__producto_tecnica_precio', 'ptp') 
                . ' ON (' . $db->quoteName('pt.id') . ' = ' . $db->quoteName('ptp.id_producto_tecnica') 
                . ' AND ' . $db->quoteName('er.id') . ' = ' . $db->quoteName('ptp.id_escala_rangos')
                . ' AND ' . $db->quoteName('u.id') . ' = ' . $db->quoteName('ptp.id_unidad') . ')'
            )
            //->where('ptp.valor > 0 ')  
            ->order($db->quoteName('p.id_modelo') . ' ASC')
            ->order($db->quoteName('t.id') . ' ASC')
            ->order($db->quoteName('u.id') . ' ASC')
            ->order($db->quoteName('er.rango_inicial') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
}