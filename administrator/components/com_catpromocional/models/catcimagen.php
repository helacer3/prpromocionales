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
class CatPromocionalModelCatCimagen extends JModelAdmin
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
		$form = $this->loadForm('com_catpromocional.catcimagen', 'catcimagen',
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
     * Method to delete Product Images.
     *
     * @return	
     * @since	2.5
     */
    public function deleteProductImages($db) {
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id_tipo_elemento') . ' = 1', 
        );
        $query->delete($db->quoteName('#__imagenes'));
        $query->where($conditions);
        $db->setQuery($query);
        $db->execute();
    }    
    /**
     * Method to get Images List.
     *
     * @return  
     * @since   2.5
     */
    public function getImagesList() {
        // Create a new query object.       
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // query
        $query
            ->select(
                array(
                    'id_elemento AS cod_producto',
                    'path AS img_nombre',
                    'nombre',
                    'es_principal',
                    'estado'
                )
            )
            ->from($db->quoteName('#__imagenes'))
            ->where($db->quoteName('id_tipo_elemento') . ' = '. $db->quote(1))
            ->order($db->quoteName('id_elemento') . ' ASC')
            ->order($db->quoteName('es_principal') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
}