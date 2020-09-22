<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0); 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
/**
 * CatPromocional Model
 */
class CatPromocionalModelCatCcotizacion extends JModelAdmin
{
    /**
     * Method to get the record form.
     *
     * @param   array   $data       Data for the form.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  mixed   A JForm object on success, false on failure
     * @since   2.5
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
     * Method to get Orders List.
     *
     * @return  
     * @since   2.5
     */
    public function getOrdersList($ftexto,$fini,$ffin) {
        // Create a new query object.       
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        // Create a new query object.
        $query->select(array('c.id', 'u.id AS user_id', 'u.NAME AS nombre_usuario',
		'u.email as email_usuario','c.comentario','c.email_cliente','c.nombre_cliente',
		'tl.nombre as tipo_lead','c.reemplazar_lead',
		'(SELECT profile_value AS company FROM prp_user_profiles 
            WHERE profile_key=\'profile.company\' AND user_id = u.id) AS compania_usuario',
			
		'(SELECT s.nombre AS sector 
		FROM prp_user_profiles pup
			INNER JOIN prp_sector s
			ON pup.profile_value = s.id
            WHERE profile_key=\'profile.sector\' AND user_id = u.id) AS sector_usuario',

		'(SELECT p.nombre AS pais 
		FROM prp_user_profiles pup
			INNER JOIN prp_pais p
			ON pup.profile_value = p.id
            WHERE profile_key=\'profile.country\' AND user_id = u.id) AS pais_usuario',
			
        '(SELECT profile_value AS city FROM prp_user_profiles 
            WHERE profile_key=\'profile.city\' AND user_id = u.id) AS ciudad_usuario',
		
		'(SELECT profile_value AS phone FROM prp_user_profiles 
            WHERE profile_key=\'profile.phone\' AND user_id = u.id) AS telefono_usuario',
		
		'(SELECT profile_value AS phone2 FROM prp_user_profiles 
            WHERE profile_key=\'profile.phone2\' AND user_id = u.id) AS movil_usuario',

        '(SELECT profile_value AS profesional FROM prp_user_profiles 
            WHERE profile_key=\'profile.profesional\' AND user_id = u.id) AS profesional_usuario',

        '(SELECT profile_value AS fechaProducto FROM prp_user_profiles 
            WHERE profile_key=\'profile.fechaProducto\' AND user_id = u.id) AS fechaproducto_usuario',		
		
		
		
        'ca.nombre as nombre_canal','pf.nombre as nombre_primera_fuente','fecha_primera_fuente',
        'ec.nombre as nombre_estado_cotizacion','c.fecha',
        'c.empresa','ci.nombre as nombre_ciudad','c.telefono'))
        ->from($db->quoteName('#__cotizacion', 'c'))            
        ->join('LEFT', $db->quoteName('#__users', 'u') 
            . ' ON (' . $db->quoteName('c.id_usuario') . ' = ' . $db->quoteName('u.id') . ')')            
        ->join('LEFT', $db->quoteName('#__tipo_lead', 'tl') 
            . ' ON (' . $db->quoteName('c.led_id') . ' = ' . $db->quoteName('tl.id') . ')')       
        ->join('LEFT', $db->quoteName('#__canal', 'ca') 
            . ' ON (' . $db->quoteName('c.id_canal') . ' = ' . $db->quoteName('ca.id') . ')')       
        ->join('LEFT', $db->quoteName('#__primera_fuente', 'pf') 
            . ' ON (' . $db->quoteName('c.id_primera_fuente') . ' = ' . $db->quoteName('pf.id') . ')')
        ->join('LEFT', $db->quoteName('#__estado_cotizacion', 'ec') 
            . ' ON (' . $db->quoteName('c.id_estado_cotizacion') . ' = ' . $db->quoteName('ec.id') . ')')

        ->join('LEFT', $db->quoteName('#__ciudades', 'ci') 
            . ' ON (' . $db->quoteName('c.id_ciudad') . ' = ' . 
            $db->quoteName('ci.id') . ')' )

        ->order('c.id DESC');            
        // Agrego el filtro si es necesario
        if(trim($ftexto) != "") {
            $query->where(
                " (u.name like '%" .$ftexto."%' OR ".
                " c.email_cliente like '%" .$ftexto."%' OR ".
                " c.comentario like '%" .$ftexto."%') ");
        }
        // Agrego el filtro fecha si es necesario
        if(trim($fini) != "" && trim($ffin) != "") {
            $query->where(
                " (DATE(fecha) >= '".$fini."' AND DATE(fecha) <= '".$ffin."') "
            );
        }
        //echo $query; exit;
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }    
    /**
     * Method to set Order State.
     *
     * @return  
     * @since   2.5
     */
    public function setState($id, $val) {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);
        // Fields to update.
        $fields = array(
            $db->quoteName('id_estado_cotizacion') . ' = '.(int)$val,
        );
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id') . ' = '.(int)$id, 
        );         
        $query->update($db->quoteName('#__cotizacion'))->set($fields)->where($conditions);
        $db->setQuery($query); 
        $db->execute();
    }
}