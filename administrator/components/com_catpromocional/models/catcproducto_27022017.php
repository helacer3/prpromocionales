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
class CatPromocionalModelCatCproducto extends JModelAdmin
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
    public function getTable($type = 'Dominio', $prefix = 'CatPromocionalTable', $config = array()) 
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
    /**
     * Method to get the Id with the Provider Name
     *
     * @return	Provider Id
     * @since	2.5
     */
    public function getProviderId($name) {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id'))
            ->from($db->quoteName('#__proveedor'))            
            ->where($db->quoteName('abreviatura') ." = ". $db->quote($name));
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    /**
     * Method to get the Id with the Model Name
     *
     * @return	Model Id
     * @since	2.5
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
     * Method to create Product.
     *
     * @return	
     * @since	2.5
     */
    public function createProduct($db,$arrData) {
        // Generate $arrInsert.
        $arrInsert = $arrData;
        unset($arrInsert['category_p']);
        unset($arrInsert['category_s']);        
        try {
            // Create a new query object.
            $query = $db->getQuery(true);
            // Prepare the insert query.
            $query
                ->insert($db->quoteName('#__producto'))
                ->columns($db->quoteName(array_keys($arrInsert)))
                ->values(implode(',', $arrInsert));
            // Set the Query.
            $db->setQuery($query);
            // Execute Query.
            //echo "<br />".$query;exit;
            $db->execute();
            // assign Categories.
            $this->assignCategories($db,$arrData);
        }
        catch (Exception $e){
            echo $e->getMessage();exit;
        }
    }
    /**
     * Method to update Product.
     *
     * @return	
     * @since	2.5
     */
    public function updateProduct($db,$arrData) {
        // Generate $arrUpdate.
        $arrUpdate = $arrData;
        unset($arrUpdate['category_p']);
        unset($arrUpdate['category_s']);
    	$fields = array();
        $query = $db->getQuery(true);		 
        // Fields to update.
        foreach ($arrUpdate as $field => $value) {
            if ($field != "id") {
                $fields[] = $db->quoteName($field) . ' = ' .$value;            
            }
        }
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id') . ' = '.(int)$arrUpdate['id']
        );		 
        $query->update($db->quoteName('#__producto'))->set($fields)->where($conditions);		 
        $db->setQuery($query);	
        //echo "<br />".$query;exit;	 
        $result = $db->execute();
        // assign Categories.
        $this->assignCategories($db,$arrData);
    }
    /**
     * Method to assing Categories to Product.
     *
     * @return	
     * @since	2.5
     */
    public function assignCategories($db,$arrData) {
        $this->deleteCategoryRelations($db, $arrData['id']);
        if ($arrData['category_p'] > 0) {
            $this->createCategoryRelation($db, $arrData['id'], $arrData['category_p'], 1);
        }
        if ($arrData['category_s'] > 0) {
            $this->createCategoryRelation($db, $arrData['id'], $arrData['category_s'], 0);
        }
    }
    /**
     * Method to delete Category Relations.
     *
     * @return	
     * @since	2.5
     */
    public function deleteCategoryRelations($db,$id) {
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id_producto') . ' = '.(int)$id, 
        );
        $query->delete($db->quoteName('#__producto_categoria'));
        $query->where($conditions);
        $db->setQuery($query);
        $db->execute();
    }    
    /**
     * Method to create Category Relation.
     *
     * @return	
     * @since	2.5
     */
    public function createCategoryRelation($db,$id,$category,$principal) {
        // Create a new query object.
        $query = $db->getQuery(true);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__producto_categoria'))
            ->columns($db->quoteName(array('id_producto','id_categoria','es_principal')))
            ->values($id.",".$category.",".$principal);
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        //echo "<br />".$query;exit;
        $db->execute();
    }    
    /**
     * Method to get Product List.
     *
     * @return  
     * @since   2.5
     */
    public function getProductsList() {
        // Create a new query object.       
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // query
        $query
            ->select(array(
                'p.id',
                'p.sku',
                'p.destacado',
                'p.nombre',
                'pr.abreviatura AS proveedor',
                '(SELECT id_categoria FROM prp_producto_categoria WHERE id_producto = p.id 
                AND es_principal = 1 LIMIT 1) AS cat_principal',
                '(SELECT id_categoria FROM prp_producto_categoria WHERE id_producto = p.id 
                AND es_principal != 1 LIMIT 1) AS cat_secundaria',
                'm.nombre AS modelo',
                'p.cnt_minima AS restriccion',
                'p.id_escala',
                'p.estado AS estado',
            ))
            ->from($db->quoteName('#__producto','p'))
            ->join('LEFT', $db->quoteName('#__proveedor', 'pr') 
                . ' ON (' . $db->quoteName('p.id_proveedor') . ' = ' . $db->quoteName('pr.id') . ')')
            ->join('LEFT', $db->quoteName('#__modelo', 'm') 
                . ' ON (' . $db->quoteName('p.id_modelo') . ' = ' . $db->quoteName('m.id') . ')')
            ->order($db->quoteName('p.id') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
}