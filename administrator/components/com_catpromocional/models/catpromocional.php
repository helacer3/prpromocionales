<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatPromocional extends JModelAdmin
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
		$form = $this->loadForm('com_catpromocional.catpromocional', 'catpromocional',
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
		$data = JFactory::getApplication()->getUserState('com_catpromocional.edit.catpromocional.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
                        $data->categorias= $this->getCategorias($data->id);
                        $data->paises = $this->getPaises($data->id);
                        $data->tecnicas = $this->getTecnicas($data->id);
                        foreach ($this->getImages($data->id) as $key => $value) {                            
                            if ($key == 0) $data->imagen_1 = $value->path;
                            else if ($key == 1) $data->imagen_2 = $value->path;
                            else if ($key == 2) $data->imagen_3 = $value->path;
                            else if ($key == 3) $data->imagen_4 = $value->path;
                        }
                        //var_dump($data);
		}
		return $data;
	}
        private function getImages ($id) {
            //SELECT path FROM jos_imagenes WHERE id_elemento=1 AND id_tipo_elemento=1 ORDER BY es_principal DESC
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('path');
            $query->from('#__imagenes');
            $query->where('id_elemento='.$db->quote($id).' AND id_tipo_elemento=1');     
            $query->order('es_principal DESC');
            $db->setQuery((string)$query);
            return $db->loadObjectList(); 
        }
        private function getCategorias ($id) {
            //SELECT id_categoria FROM jos_producto_categoria WHERE id_producto = 1;
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id_categoria');
            $query->from('#__producto_categoria');
            $query->where('id_producto='.$db->quote($id));     
            $db->setQuery((string)$query);
            return $db->loadColumn(); 
        }
        private function getPaises ($id) {
            //SELECT id_pais FROM jos_producto_pais WHERE id_producto = 1;
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id_pais');
            $query->from('#__producto_pais');
            $query->where('id_producto='.$db->quote($id));     
            $db->setQuery((string)$query);
            return $db->loadColumn(); 
        }
        private function getTecnicas ($id) {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id_tecnica');
            $query->from('#__producto_tecnica');
            $query->where('id_producto='.$db->quote($id));     
            $db->setQuery((string)$query);
            return $db->loadColumn(); 
        }
        /******************************************************************************/
        public function setValue($id,$pb,$type) {
            // Cargo y actualizo registro
            $table = $this->getTable();
            $table->load($id);
            // set updating fields data
            if ($type == 1)
                $table->estado = $pb;
            else
                $table->publicado = $pb;
            $table->store($table);
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function insertImage($cod,$pathImagen,$principal) {
            //echo "<br />aca ".$cod." - ".$path." - ".$principal;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('path', 'id_elemento', 'id_tipo_elemento', 'es_principal','estado');
            $values = array($db->quote($pathImagen),$db->quote($cod),1,$principal,1);
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
            $query->where('id_elemento='.$db->quote($cod).' AND id_tipo_elemento=1');              
            $db->setQuery($query);
            $db->query();
        }

        function saveProductImages($cod,$imagenes) {
            //echo "<br /> aca ".$cod;
            // Elimino las relaciones de imagenes de los productos.
            $this->deleteImages($cod);
            // Guardo las imagenes.
            foreach ($imagenes as $key => $imagen) {

                //echo "<br />imagen ".$key." - ".$imagen;
                if ($imagen != "") {
                    $key == 1 ? $principal = 1: $principal = 0;
                    $this->insertImage($cod, $imagen, $principal);
                }
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function insertCategorie($cod,$categoria,$principal) {
            //echo "<br />aca ".$cod." - ".$path." - ".$principal;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id_producto', 'id_categoria', 'es_principal');
            $values = array($db->quote($cod),$db->quote($categoria),$principal);
            $query->insert($db->quoteName('#__producto_categoria'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();        
        }

        function deleteCategories($cod) {
            $db = & JFactory::getDBO();   
            $query = $db->getQuery(true);
            $query->delete('#__producto_categoria');             
            $query->where('id_producto='.$db->quote($cod));              
            $db->setQuery($query);
            $db->query();
        }

        function saveProductCategories($cod,$categorias) {
            //echo "<br /> aca ".$cod;
            // Elimino las relaciones de categorias del producto.
            $this->deleteCategories($cod);
            // Guardo las categorias.
            foreach ($categorias as $key => $categoria) {
                $key == 0 ? $principal = 1: $principal = 0;
                $this->insertCategorie($cod, $categoria, $principal);
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function insertCountry($cod,$producto) {
            //echo "<br />aca ".$cod." - ".$path." - ".$principal;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id_producto', 'id_pais');
            $values = array($db->quote($cod),$db->quote($producto));
            $query->insert($db->quoteName('#__producto_pais'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();        
        }

        function insertRelationedProduct($cod,$producto) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id_producto', 'id_producto_relacionado');
            $values = array($db->quote($cod),$db->quote($producto));
            $query->insert($db->quoteName('#__producto_relacionado'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();        
        }        
        
        function deleteCountries($cod) {
            $db = & JFactory::getDBO();   
            $query = $db->getQuery(true);
            $query->delete('#__producto_pais');             
            $query->where('id_producto='.$db->quote($cod));              
            $db->setQuery($query);
            $db->query();
        }

        function deleteRelationedProducts($cod) {
            $db = & JFactory::getDBO();   
            $query = $db->getQuery(true);
            $query->delete('#__producto_relacionado');             
            $query->where('id_producto='.$db->quote($cod));              
            $db->setQuery($query);
            $db->query();
        }        
        
        function saveProductCountries($cod,$productos) {
            //echo "<br /> aca ".$cod;
            // Elimino las relaciones de paises del producto.
            $this->deleteCountries($cod);
            // Guardo los paises.
            foreach ($productos as $producto) {
                $this->insertCountry($cod, $producto, $principal);
            }
        }
        
        function saveRelationedProducts($cod,$productos) {
            // Elimino los productos relacionados.
            $this->deleteRelationedProducts($cod);
            // Guardo los productos relacionados.
            foreach ($productos as $producto) {
                $this->insertRelationedProduct($cod, $producto);
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function insertTechnique($cod,$tecnica) {
            //echo "<br />aca ".$cod." - ".$path." - ".$principal;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('id_producto', 'id_tecnica');
            $values = array($db->quote($cod),$db->quote($tecnica));
            $query->insert($db->quoteName('#__producto_tecnica'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();        
        }

        function deleteTechniques($cod) {
            $db = & JFactory::getDBO();   
            $query = $db->getQuery(true);
            $query->delete('#__producto_tecnica');             
            $query->where('id_producto='.$db->quote($cod));              
            $db->setQuery($query);
            $db->query();
        }

        function saveRelationedTechniques($cod,$techniques) {
            //echo "<br /> aca ".$cod;
            // Elimino las relaciones de técnicas del producto.
            $this->deleteTechniques($cod);
            // Guardo las categorias.
            foreach ($techniques as $key => $technique) {
                $this->insertTechnique($cod, $technique);
            }
        }        
        //////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////          
        protected function prepareTable($table)
        {
            // Zona horaria por defecto.
            date_default_timezone_set("America/Bogota");
            // Valido si estoy actualizando.
            if (empty($table->id))
                $table->fec_creacion = date("Y-m-d- H:i:s");
            // fecha modificación
            $table->fec_ultmodifica = date("Y-m-d- H:i:s");
        }
}