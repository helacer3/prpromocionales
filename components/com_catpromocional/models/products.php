<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_catpromocional
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

/**
 * Products model for the Joomla Banners component.
 *
 * @since  1.5
 */
class CatpromocionalModelProducts extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // Get Products Outstanding
    ////////////////////////////////////////////////////////////////////////////
    public function getProductsOutstanding($PrdPagination,$limit=1)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true);
        // Validate select info.
        if ($limit == 1) {
            $query->select(array('DISTINCT p.id', 'p.nombre', 'p.descripcion', 'i.path'));
        } else {
            $query->select(array('COUNT(DISTINCT p.id)'));
        }
        // Set Conditions
        $query->from($db->quoteName('#__producto', 'p'))
            ->join('LEFT', $db->quoteName('#__producto_categoria', 'pc') . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('pc.id_producto') . ')')
            ->join('LEFT', $db->quoteName('#__imagenes', 'i') 
                . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('i.id_elemento') . ')'
                . ' AND '.$db->quoteName('i.estado').' = '.$db->quote(1)
                . ' AND '.$db->quoteName('i.id_tipo_elemento').' = '.$db->quote(1)
            )
            ->where($db->quoteName('p.destacado') ." = ". $db->quote(1))
            ->where($db->quoteName('p.publicado') ." = ". $db->quote(1))
            ->where($db->quoteName('p.estado') ." = ". $db->quote(1));
        // Add order to query.
        $query->order($db->quoteName('p.id') . ' DESC');
        // Add limit to query.
        if ($limit == 1) {
            $query->setLimit($PrdPagination[1],$PrdPagination[0]);
            // Prepare the query
            $db->setQuery($query);
            //echo "<br /> ".$query."<br /> ";
            // Return the Products object
            return $db->loadObjectList();
        } else {
            // Prepare the query
            $db->setQuery($query);
            //echo "<br /> ".$query."<br /> ";
            // Return result.
            return $db->loadResult();
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Products Category
    ////////////////////////////////////////////////////////////////////////////
    public function getProductsCategory($idcategory, $PrdPagination, $wordSearch="", $arrProducts, $limit=1)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true);
        // Validate select info.
        if ($limit == 1) {
            $query->select(array('DISTINCT p.id', 'p.nombre', 'p.descripcion', 'i.path'));
        } else {
            $query->select(array('COUNT(DISTINCT p.id)'));
        }
        // Set Conditions
        $query->from($db->quoteName('#__producto', 'p'))
            ->join('LEFT', $db->quoteName('#__producto_categoria', 'pc') 
            . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('pc.id_producto') . ')')

            ->join('LEFT', $db->quoteName('#__proveedor', 'pr') 
            . ' ON (' . $db->quoteName('p.id_proveedor') . ' = ' . $db->quoteName('pr.id') . ')')
            ->join('LEFT', $db->quoteName('#__imagenes', 'i') 
                . ' ON (' .$db->quoteName('p.id') . ' = ' . $db->quoteName('i.id_elemento') . ')'
                . ' AND '.$db->quoteName('i.estado').' = '.$db->quote(1)
                . ' AND '.$db->quoteName('i.id_tipo_elemento').' = '.$db->quote(1)
                . ' AND '.$db->quoteName('i.es_principal').' = '.$db->quote(1)
                //. ' AND '.$db->quoteName('i.es_principal').' = '.$db->quote(1)
            )
            ->where($db->quoteName('p.publicado') ." = ". $db->quote(1))
            ->where($db->quoteName('p.estado') ." = ". $db->quote(1));
        // Validate search product
        if (trim($wordSearch) != "") {
            // Add Percentajes Like
            $wordSearch = "%".htmlentities(trim($wordSearch))."%";
            // Add Conditional Search.
            $query->where("(".
                $db->quoteName('p.nombre') ." LIKE ".$db->quote($wordSearch)." OR ".
                $db->quoteName('p.sku') ." LIKE ".$db->quote($wordSearch)." OR ".
                $db->quoteName('p.referencia') ." LIKE ".$db->quote($wordSearch)." OR ".
                $db->quoteName('p.descripcion') ." LIKE ".$db->quote($wordSearch)." OR ".
                $db->quoteName('p.especificaciones') ." LIKE ".$db->quote($wordSearch)
            .")");
        }
        else if (count($arrProducts) > 0 ) {
            //d($arrProducts);
            // set Query.
            $query->where($db->quoteName('p.id') ." IN (".implode(',',$arrProducts).") ");
        } else {
            $query->where($db->quoteName('pc.id_categoria') ." = ". $db->quote($idcategory));
        }
        // Add order to query.
        $query = $this->getOrderQuery($db, $query);
        //echo "<br />TODOS<br />  ".$query."<br /> ";
        // Add limit to query.
        if ($limit == 1) {
            $query->setLimit($PrdPagination[1],$PrdPagination[0]);
            //echo "<br />TODOS<br />  ".$query."<br /> ";
            // Prepare the query
            $db->setQuery($query);
            // Return the Products object
            return $db->loadObjectList();
        } else {
            //echo "<br />LIMIT<br /> ".$query."<br /> ";exit;
            // Prepare the query
            $db->setQuery($query);
            // Return result.
            return $db->loadResult();
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Product info
    ////////////////////////////////////////////////////////////////////////////
    public function getProductInfo($idproduct)
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('p.id', 'p.nombre', 'p.descripcion','p.cnt_minima','p.especificaciones',
                'p.sku','p.referencia','p.publicado','pr.nombre as proveedor'))
            ->from($db->quoteName('#__producto', 'p'))
            ->join('LEFT', $db->quoteName('#__proveedor', 'pr') 
                . ' ON (' . $db->quoteName('p.id_proveedor') . ' = ' . $db->quoteName('pr.id').')')
            ->where($db->quoteName('p.id') ." = ". $db->quote($idproduct))
            ->order($db->quoteName('p.nombre') . ' ASC')
            ->setLimit(12);
        // Prepare the query
        $db->setQuery($query);
        // Load the row
        return $db->loadObject();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Product name
    ////////////////////////////////////////////////////////////////////////////
    public function getProductName($idproduct)
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('p.nombre'))
            ->from($db->quoteName('#__producto', 'p'))            
            ->where($db->quoteName('p.id') ." = ". $db->quote($idproduct));
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Product Single Info
    ////////////////////////////////////////////////////////////////////////////
    public function getProductSingleInfo($idproduct)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('i.path','p.nombre','p.descripcion','p.referencia','p.cnt_minima'))
            ->from($db->quoteName('#__producto', 'p'))  
            ->join('LEFT', $db->quoteName('#__imagenes', 'i') 
                . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('i.id_elemento')  
                . ' AND '.$db->quoteName('i.id_tipo_elemento') . ' = 1'
                . ' AND '.$db->quoteName('i.es_principal') . ' = 1)'
                )  
            ->where($db->quoteName('p.id') ." = ". (int)$idproduct)
            ->order($db->quoteName('i.es_principal') . ' DESC')
            ->setLimit(1);
        //echo "<br />aca ".$query;
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadAssoc();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Set Disable Product
    ////////////////////////////////////////////////////////////////////////////
    public function setDisableProduct($idproduct,$publicado)
    {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);
        // Fields to update.
        $fields = array(
            $db->quoteName('publicado') . ' = '.(int)$publicado,
        );
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id') . ' = ' .(int)$idproduct,
        );
        $query->update($db->quoteName('#__producto'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $db->execute(); 
    }
    ////////////////////////////////////////////////////////////////////////////
    // Set View Product Info.
    ////////////////////////////////////////////////////////////////////////////
    public function setViewProductInfo($idproduct, $iduser) {
        // Get a db connection.
        $db = JFactory::getDbo();       
        // Create a new query object.
        $query = $db->getQuery(true);         
        // Insert columns.
        $columns = array('id_producto', 'id_user', 'fecha');
        // Insert values.
        $values = array((int)$idproduct, (int)$iduser, 'NOW()');
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__visualiza_productos'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values)); 
        // Set the query using our newly populated query object and execute it.
        $db->setQuery($query);
        $db->execute();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Sort Products
    ////////////////////////////////////////////////////////////////////////////
    public function getSortProducts()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('criterio_ordenamiento'))
            ->from($db->quoteName('#__textocotizacion'))            
            ->where($db->quoteName('id') .' = 1');
        // Prepare the query
        $db->setQuery($query);
        // Return result
        return $db->loadResult();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get most Visited Products
    ////////////////////////////////////////////////////////////////////////////
    public function getMostVisitedProducts()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id_producto'))
            ->from($db->quoteName('#__visualiza_productos'))
            ->group($db->quoteName('id_producto'))           
            ->order('COUNT(id_producto) ASC');
        // Prepare the query
        $db->setQuery($query);
        //echo "<br />".$query;
        // Return result
        return $db->loadColumn();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Order Query
    ////////////////////////////////////////////////////////////////////////////
    public function getOrderQuery($db, $query) {
        $order = $this->getSortProducts();
        switch ((int)$order) {
            case 3:
                return  $query->order($db->quoteName('pr.orden') . ' DESC');
                break;
            case 2:
                $order = $this->getMostVisitedProducts();
                return  $query->order('FIELD('.implode(",",$order).') DESC');
                break;
            default:
                return  $query->order($db->quoteName('p.nombre') . ' ASC');
                break;
        }
    }
}
