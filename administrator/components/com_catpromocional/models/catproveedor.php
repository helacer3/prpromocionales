<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatProveedor extends JModelAdmin
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
	public function getTable($type = 'Proveedor', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catproveedor', 'catproveedor',
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
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catproveedor.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
        public function setValue($id,$pb) {
            // Cargo y actualizo registro
            $table = $this->getTable();
            $table->load($id);
            // set updating fields data
            $table->estado = $pb;
            $table->store($table);
        }
        
        public function extProveedor($id) {
            $db =& JFactory::getDBO();
            $query = "SELECT COUNT(*) FROM #__proveedor WHERE id = '".$id."'";
            $db->setQuery($query);
            return $db->loadResult();
        } 
        public function addProveedor($jForm) {            
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id', 'nombre', 'descripcion', 'abreviatura','estado');
            $values = array(
                $db->quote($jForm['id']),
                $db->quote($jForm['nombre']),
                $db->quote($jForm['descripcion']),
                $db->quote($jForm['abreviatura']),
                $db->quote($jForm['estado']));
            $query->insert($db->quoteName('#__proveedor'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();            
        }   
}