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
class CatPromocionalModelCatOrdproducto extends JModelAdmin
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
    public function getTable($type = 'Producto', $prefix = 'CatPromocionalTable', $config = array()) 
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
        $form = $this->loadForm('com_catpromocional.catcproducto', 'catcproducto',
                                array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) 
        {
                return false;
        }
        return $form;
    }
    /*
    * set Order Providers
    */
    public function setOrderProviders($id,$order) {     
        $db = JFactory::getDBO();
        // Fields to update.
        $fields = array(
            $db->quoteName('orden') . ' = '.(int)$order
        );         
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id') . ' = '.(int)$id
        );
        // Run update.
        $this->updateRegister($db,'#__proveedor',$fields,$conditions);
    }
    /*
    * set Parameter Order
    */
    public function setParameterOrder($val) {     
        $db = JFactory::getDBO();
        // Fields to update.
        $fields = array(
            $db->quoteName('criterio_ordenamiento') . ' = '.(int)$val
        );         
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id') . ' = 1'
        );
        // Run update.
        $this->updateRegister($db,'#__textocotizacion',$fields,$conditions);
    }
    /*
    * set Order Manufacturer
    */
    public function updateRegister($db,$table,$fields,$conditions) {
        $query = $db->getQuery(true);
        $query->update($db->quoteName($table))->set($fields)->where($conditions); 
        $db->setQuery($query);
        //echo "\n".$query;
        $db->execute();
    }
    /*
    * get Providers
    */
    public function getProviders() {
        //SELECT id, nombre FROM prp_proveedor WHERE estado = 1 ORDER BY orden ASC        
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id','nombre'))
            ->from($db->quoteName('#__proveedor'))            
            ->where($db->quoteName('estado') ." = 1")
            ->order('orden ASC');
        // Prepare the query
        $db->setQuery($query);
        // Return Object List
        return $db->loadObjectList();
    }
    /*
    * get Sorter Criteria
    */
    public function getSorterCriteria() {        
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('criterio_ordenamiento'))
            ->from($db->quoteName('#__textocotizacion'))            
            ->where($db->quoteName('id') ." = 1");
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
}