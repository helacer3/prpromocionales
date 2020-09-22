<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatAsgCosto extends JModelAdmin
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
	public function getTable($type = 'Costofijo_tecnica', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catasgcosto', 'catasgcosto',
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
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catasgcosto.data', array());
		if (empty($data)) 
		{
                    $data = $this->getItem();
                    $asgCost = $this->getAsgCostByid($data->id);
                    $data->id_tecnica = $asgCost->id_tecnica;
                    $data->id_escala = $asgCost->id_escala;
                    $data->id_costofijo = $asgCost->id_costofijo;
                    $data->id_tipo_costofijo = $asgCost->id_tipo_costofijo;
                    $data->id_tipo_precio = $asgCost->id_tipo_precio;
                    $data->valor = $asgCost->valor;
                    $data->estado = $asgCost->estado;
		}
		return $data;
	}
        
        ////////////////////////////////////////////////////////////////////////
        // get Asign Cost By Id.
        ////////////////////////////////////////////////////////////////////////        
        public function getAsgCostByid($id)
        {		
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('tcf.id_tecnica','tcf.id_costofijo','er.id_escala',
                'tcp.id_tipo_costofijo','tcp.id_tipo_precio','tcp.valor','tcp.estado'))
                ->from($db->quoteName('#__tecnica_costofijo_precio', 'tcp'))
                ->join('LEFT', $db->quoteName('#__tecnica_costofijo', 'tcf') 
                . ' ON (' . $db->quoteName('tcp.id_tecnica_costofijo') . ' = ' . $db->quoteName('tcf.id') . ')')
                ->join('LEFT', $db->quoteName('#__escala_rangos', 'er') 
                . ' ON (' . $db->quoteName('tcp.id_escala_rangos') . ' = ' . $db->quoteName('er.id') . ')')
                ->where($db->quoteName('tcp.id') ." = ".(int)$id);
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
        public function getListScaleRanges($id=0) {        
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('id','CONCAT(rango_inicial,\' - \',rango_final) AS nombre'))
                ->from($db->quoteName('#__escala_rangos'))
                ->where($db->quoteName('id_escala') ." = ".(int)$id)
                ->where($db->quoteName('estado') ." = ". $db->quote(1))
                ->order($db->quoteName('id') . ' ASC');
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


