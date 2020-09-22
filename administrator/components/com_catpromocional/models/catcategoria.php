<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatCategoria extends JModelAdmin
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
	public function getTable($type = 'Categoria', $prefix = 'CatPromocionalTable', $config = array()) 
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
		$form = $this->loadForm('com_catpromocional.catcategoria', 'catcategoria',
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
        public function setValue($id,$pb) {
            // Cargo y actualizo registro
            $table = $this->getTable();
            $table->load($id);
            // set updating fields data
            $table->estado = $pb;
            $table->store($table);
        }
        /************************************************************************/
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function insertImage($cod,$pathImagen,$principal) {
            //echo "<br />aca ".$cod." - ".$path." - ".$principal;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('path', 'id_elemento', 'id_tipo_elemento', 'es_principal','estado');
            $values = array($db->quote($pathImagen),$db->quote($cod),2,$principal,1);
            $query->insert($db->quoteName('#__imagenes'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();        
        }

        function deleteImages($cod) {
            $db = & JFactory::getDBO();   
            $query = $db->getQuery(true);
            $query->delete('#__imagenes');             
            $query->where('id_elemento = '.$db->quote($cod).' AND id_tipo_elemento = 2');              
            $db->setQuery($query);
            $db->query();
        }

        function saveProductImages($cod,$imagen) {
            //echo "<br /> aca ".$cod;
            // Elimino las relaciones de imagenes de los productos.
            $this->deleteImages($cod);
            // Guardo las imagenes.
            $this->insertImage($cod, $imagen, 1);
        }       
        /************************************************************************/
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	2.5
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catcategoria.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
}