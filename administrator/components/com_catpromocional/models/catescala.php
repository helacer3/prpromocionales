<?php
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatEscala extends JModelAdmin
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
	public function getTable($type = 'Escala', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catescala', 'catescala',
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
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catescala.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
        // Set Value
        public function setValue($id,$pb) {
            // Cargo y actualizo registro
            $table = $this->getTable();
            $table->load($id);
            // set updating fields data
            $table->estado = $pb;
            $table->store($table);
        }
        // Save Scale Categories.
        function saveScaleCategories($cod,$categorias) {
            if (count($categorias) > 0) {
                foreach ($categorias as $categoria) {
                    $this->insertScaleCategorie($cod, $categoria);
                    $this->updateScaleProducts($cod, $categoria);
                }
            }
        }
        // Insert Scale Categories.
        function insertScaleCategorie($cod,$categoria) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id_escala', 'id_categoria', 'fecha');
            $values = array($db->quote($cod),$db->quote($categoria),'NOW()');
            $query->insert($db->quoteName('#__escala_categoria'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();            
        }
        // Update Scale Products.
         function updateScaleProducts($cod,$categoria) {
            $db = JFactory::getDbo();
            $query = "UPDATE prp_producto pp 
            INNER JOIN prp_producto_categoria ppc 
            ON pp.id = ppc.id_producto
            SET id_escala = ".(int)$cod
            ." WHERE ppc.id_categoria = ".(int)$categoria;
            $db->setQuery($query);
            $db->execute();            
        }       
}