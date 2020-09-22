<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatPrpTecnica extends JModelAdmin
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
	public function getTable($type = 'Prptecnica', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catprptecnica', 'catprptecnica',
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	2.5
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catprptecnica.data', array());
		if (empty($data)) 
		{
                    $data = $this->getItem();
                    $prpTech = $this->getPrdtechUniPrice($data->id);
                    $data->id_producto = $prpTech->id_producto;
                    $data->id_tipo_precio = $prpTech->id_tipo_precio;
                    $data->id_escala = $prpTech->id_escala;
                    $data->rango_inicial = $prpTech->rango_inicial;
                    $data->rango_final = $prpTech->rango_final;
                    $data->valor = $prpTech->valor;
                    $data->estado = $prpTech->estado;
		}
		return $data;
	}
        
        ////////////////////////////////////////////////////////////////////////
        // get Product - Unit - Technique Price
        ////////////////////////////////////////////////////////////////////////        
        public function getPrdtechUniPrice($id)
        {	
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('pt.id_producto','pt.id_tecnica','ptp.id_unidad','er.id_escala',
                'ptp.id_tipo_precio','er.rango_inicial','er.rango_final','ptp.valor','ptp.estado'))
                ->from($db->quoteName('#__producto_tecnica_precio', 'ptp'))
                ->join('LEFT', $db->quoteName('#__producto_tecnica', 'pt') 
                . ' ON (' . $db->quoteName('ptp.id_producto_tecnica') . ' = ' . $db->quoteName('pt.id') . ')')
                ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('ptp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')
                ->where($db->quoteName('ptp.id') ." = ".(int)$id);
            // Prepare the query
            $db->setQuery($query);
            // Return result
            return $db->loadObject();
        }
        ////////////////////////////////////////////////////////////////////////
        // Method set value
        ////////////////////////////////////////////////////////////////////////
        public function setValue($id,$pb) {
            // Cargo y actualizo registro
            $table = $this->getTable();
            $table->load($id);
            // set updating fields data
            $table->estado = $pb;
            $table->store($table);
        }
        
        ////////////////////////////////////////////////////////////////////////
        // Get List Scale Ranges.
        ////////////////////////////////////////////////////////////////////////
        public function getListTechniquesByProduct($id=0) {           
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('pt.id as id_producto_tecnica','t.id as id_tecnica','t.nombre'))
                ->from($db->quoteName('#__producto_tecnica','pt'))
                ->join('LEFT', $db->quoteName('#__tecnica', 't') 
                . ' ON (' . $db->quoteName('pt.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
                ->where($db->quoteName('pt.id_producto') ." = ".(int)$id)
                ->order($db->quoteName('t.nombre') . ' ASC');
            // Prepare the query
            $db->setQuery($query);
            // Load the row.
            return $db->loadObjectList();
        }
        
         ////////////////////////////////////////////////////////////////////////
        // Get List Units By Technique
        ////////////////////////////////////////////////////////////////////////
        public function getListUnitsByTechnique($id=0) {           
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('id','nombre'))
                ->from($db->quoteName('#__unidad'))
                ->where($db->quoteName('id_tecnica') ." = ".(int)$id)
                ->order($db->quoteName('nombre') . ' ASC');
            // Prepare the query
            $db->setQuery($query);
            // Load the row.
            return $db->loadObjectList();
        }
        
        ////////////////////////////////////////////////////////////////////////
        // Method Save Costo Fijo Técnica
        ////////////////////////////////////////////////////////////////////////
        public function saveCostoFijoTecnica($costoFijo) {
            if ($costoFijo['id'] > 0) {
                $id = $this->insertCostoFijoTecnica($costoFijo);
                $this->updateCostoFijoTecnicaPrecio($id,$costoFijo);  
            } else {
                $id = $this->insertCostoFijoTecnica($costoFijo);
                $this->insertCostoFijoTecnicaPrecio($id,$costoFijo);            
            }
        }
        ////////////////////////////////////////////////////////////////////////
        // Insert Costo Fijo Técnica
        ////////////////////////////////////////////////////////////////////////
        public function insertCostoFijoTecnica($costoFijo) {
            // Get a db connection.
            $db = JFactory::getDbo();
            // Insert columns.
            $columns = array('id_tecnica','id_costofijo');
            // Insert values.
            $values = array($costoFijo['id_tecnica'],$costoFijo['id_costofijo']); 
            // Create a new query object.
            $query = $db->getQuery(true);
            // Prepare the insert query.
            $query
                ->insert($db->quoteName('#__tecnica_costofijo'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            // Set the Query.
            $db->setQuery($query);
            // Execute Query.
            $db->execute();
            //echo "<br /><br />".$query;
            // Return Id
            return $db->insertid();
        }
        ////////////////////////////////////////////////////////////////////////
        // Insert Costo Fijo Técnica Precio
        ////////////////////////////////////////////////////////////////////////
        public function insertCostoFijoTecnicaPrecio($id,$costoFijo) {
            // Get a db connection.
            $db = JFactory::getDbo();
            //echo "<pre>"; var_dump($costoFijo); echo "</pre><br />";exit;
            // Insert columns.
            $columns = array('id_tecnica_costofijo','id_escala_rangos',
                'id_tipo_costofijo','id_tipo_precio','valor','estado');
            // Insert values.
            $values = array((int)$id,$costoFijo['id_escala_rango'],
                $costoFijo['id_tipo_costofijo'],$costoFijo['id_tipo_precio'],
                $costoFijo['valor'],$costoFijo['estado']
            ); 
            // Create a new query object.
            $query = $db->getQuery(true);
            // Prepare the insert query.
            $query
                ->insert($db->quoteName('#__tecnica_costofijo_precio'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            // Set the Query.
            $db->setQuery($query);
            // Execute Query.
            $db->execute();
            //echo "<br /><br />".$query;
            // Return Id
            return $db->insertid();
        }
        ////////////////////////////////////////////////////////////////////////
        // Update Costo Fijo Técnica Precio
        ////////////////////////////////////////////////////////////////////////
        public function updateCostoFijoTecnicaPrecio($id,$costoFijo) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            // Fields to update.
            $fields = array(
                $db->quoteName('id_tecnica_costofijo') . ' = ' .(int)$id,
                $db->quoteName('id_escala_rangos') . ' = ' .(int)$costoFijo['id_escala_rango'],
                $db->quoteName('id_tipo_costofijo') . ' = ' .(int)$costoFijo['id_tipo_costofijo'],
                $db->quoteName('id_tipo_precio') . ' = ' .(int)$costoFijo['id_tipo_precio'],
                $db->quoteName('valor') . ' = ' .(int)$costoFijo['valor'],
                $db->quoteName('estado') . ' = ' .(int)$costoFijo['estado']
            );
            // Conditions for which records should be updated.
            $conditions = array(
                $db->quoteName('id') . ' = '.(int)$costoFijo['id'], 
            );
            $query->update($db->quoteName('#__tecnica_costofijo_precio'))->set($fields)->where($conditions);
            $db->setQuery($query);
            $result = $db->execute();
        }
}


