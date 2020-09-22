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
class CatPromocionalModelCatLimcotiza extends JModelAdmin
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
	public function getTable($type = 'Limcotiza', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catlimcotiza', 'catlimcotiza',
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
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catlimcotiza.data', array());
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
    public function getQuotationsByUser ($id) {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('COUNT(id)');
        $query->from('#__cotizacion');
        $query->where('id_usuario = '.$db->quote($id));     
        $db->setQuery((string)$query);
        return $db->loadResult(); 
    } 
    
    public function setQuotationsByUser ($model) {
        date_default_timezone_set("America/Bogota");
        $item = $model->getItem();
        $fecha = date("Y-m-d H:i:s");
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        // Fields to update.
        $fields = array(
            $db->quoteName('cantidad_total') . ' = ' . (int)$this->getQuotationsByUser($item->get('id_usuario')),
            $db->quoteName('fecha') . ' = ' .$db->quote(date("Y-m-d H:i:s"))
        );
        // Conditions for which records should be updated.
        $conditions = array($db->quoteName('id') . ' = '.(int)$item->get('id'));
        $query->update($db->quoteName('#__limita_cotizaciones'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $result = $db->execute();            
    }
}