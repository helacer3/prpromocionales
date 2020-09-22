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
 * Quotation model for the Joomla CatPromocional component.
 *
 * @since  1.5
 */
class CatpromocionalModelCnsquotation extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotation($id)
    {		
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('c.id','c.id_usuario','c.nombre_cliente','c.email_cliente','c.comentario',
                'tl.nombre as nombre_tipo_lead','reemplazar_lead','cn.nombre as nombre_canal',
                'pf.nombre as nombre_primera_fuente','fecha_primera_fuente','c.fecha'))
            ->from($db->quoteName('#__cotizacion','c')) 
            ->join('LEFT', $db->quoteName('#__tipo_lead', 'tl') 
                . ' ON (' . $db->quoteName('c.led_id') . ' = ' . $db->quoteName('tl.id') . ')')
            ->join('LEFT', $db->quoteName('#__canal', 'cn') 
                . ' ON (' . $db->quoteName('c.id_canal') . ' = ' . $db->quoteName('cn.id') . ')')
            ->join('LEFT', $db->quoteName('#__primera_fuente', 'pf') 
                . ' ON (' . $db->quoteName('c.id_primera_fuente') . ' = ' . $db->quoteName('pf.id') . ')')
            ->where($db->quoteName('c.id') ." = ".(int)$id);
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObject();
        
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation Items
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationItems($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('ci.id','p.nombre','ci.id_producto','p.descripcion',
                'p.referencia','p.especificaciones','ci.cantidad','ci.valor'))
            ->from($db->quoteName('#__cotizacion_item','ci'))
            ->join('LEFT', $db->quoteName('#__producto', 'p') 
                . ' ON (' . $db->quoteName('ci.id_producto') . ' = ' . $db->quoteName('p.id') . ')')
            ->where($db->quoteName('ci.id_cotizacion') ." = ".(int)$id)
            ->order($db->quoteName('ci.id_producto') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation Item Logos
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationItemLogos($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('cil.id','cil.logo','cil.id_tecnica','t.nombre AS tecnica',
                        'cil.id_unidad','CONCAT(u.cantidad,\' \',u.nombre) AS unidad','cil.valor_tecnica'))
            ->from($db->quoteName('#__cotizacion_item_logo','cil'))
            ->join('LEFT', $db->quoteName('#__tecnica', 't') 
                . ' ON (' . $db->quoteName('cil.id_tecnica') . ' = ' . $db->quoteName('t.id') . ')')
            ->join('LEFT', $db->quoteName('#__unidad', 'u') 
                . ' ON (' . $db->quoteName('cil.id_unidad') . ' = ' . $db->quoteName('u.id') . ')')
            ->where($db->quoteName('cil.id_cotizacion_item') ." = ".(int)$id)
            ->order($db->quoteName('cil.logo') . ' ASC');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation Item Cost Fixed
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationItemCF($id)
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('cic.id','cic.id_costofijo','cf.nombre AS costofijo',
                'cic.valor_costofijo','cic.id_tipo_precio','cic.id_tipo_costofijo'))
            ->from($db->quoteName('#__cotizacion_item_costofijo','cic'))
            ->join('LEFT', $db->quoteName('#__costofijo', 'cf') 
                . ' ON (' . $db->quoteName('cic.id_costofijo') . ' = ' . $db->quoteName('cf.id') . ')')
            ->where($db->quoteName('cic.id_cotizacion_item_logo') ." = ".(int)$id)
            ->order($db->quoteName('cic.id_costofijo') . ' ASC');
        //echo "<br />".$query;
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
    }

    ////////////////////////////////////////////////////////////////////////////
    // Get Price Mrc Logo 
    ////////////////////////////////////////////////////////////////////////////
    public function getPriceMrcLogo($logo,$item)
    {
        //echo "<pre>";var_dump($logo);echo "</pre><br />";
        // Set Vars.
        $prclogo = 0;
        //echo "<br /> Tecnica: ".$logo->valor_tecnica."-".$logo->id;
        $prclogo += $logo->valor_tecnica / $item->cantidad;
        // Get Info Fixed Cost Item
        $cfproduct = $this->getQuotationItemCF($logo->id);
        // Loop Fixed Cost.                                    
        if (count($cfproduct) > 0) {
            foreach ($cfproduct as $fcost) {
                $prclogo += $fcost->valor_costofijo / $item->cantidad;
            }
        }
        // return price mrclogo.
        return $prclogo;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation Text
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationText()
    {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('introduccion','estado','terminos','footer',
            'correo_destino1','correo_destino2','correo_destino3','correo_destino4',
            'correo_destino5','correo_destino6','correo_destino7','correo_destino8'))
            ->from($db->quoteName('#__textocotizacion'))
            ->where($db->quoteName('id') ." = 1");
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObject();
    }   
    ////////////////////////////////////////////////////////////////////////////
    // Get Limit Quotation By User
    ////////////////////////////////////////////////////////////////////////////    
    public function getLimitQuotationByUser($id){
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('IF (lc.cantidad_actual < lc.cantidad_total,1,0) AS limite'))
            ->from($db->quoteName('#__limita_cotizaciones','lc'))
            ->join('LEFT', $db->quoteName('#__categoria_limita', 'cl') 
            . ' ON (' . $db->quoteName('lc.id_categoria_limita') . ' = ' . $db->quoteName('cl.id') . ')')
            ->where($db->quoteName('lc.id_usuario') ." = ".(int)$id);
        // Prepare the query
        $db->setQuery($query);
        // Validate exist result.
        if (count($db->loadResult()) == 0)
            return 1;
        else
            // Load the row.
            return $db->loadResult();        
    }   
    ////////////////////////////////////////////////////////////////////////////
    // Update Limit Quotation By User
    ////////////////////////////////////////////////////////////////////////////    
    public function updateLimitQuotationByUser($id) {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);
        // Fields to update.
        $fields = array(
            $db->quoteName('cantidad_actual') . ' = '.$db->quoteName('cantidad_actual').' + 1',
        );
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('id_usuario') . ' = ' .(int)$id,
        );
        $query->update($db->quoteName('#__limita_cotizaciones'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $db->execute();
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation Cantity By User
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationCantityByUser($id){
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('COUNT(c.id)'))
            ->from($db->quoteName('#__cotizacion','c'))
            ->join('LEFT', $db->quoteName('#__users', 'u') 
            . ' ON (' . $db->quoteName('c.email_cliente') . ' = ' . $db->quoteName('u.email') . ')')
            ->where($db->quoteName('c.id_usuario') ." = ".(int)$id);
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadResult();        
    } 
    ////////////////////////////////////////////////////////////////////////////
    // Get Quotation By user
    ////////////////////////////////////////////////////////////////////////////
    public function getQuotationByuser($id)
    {       
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('id','fecha'))
            ->from($db->quoteName('#__cotizacion'))
            ->where($db->quoteName('id_usuario') ." = ".(int)$id)
            ->order($db->quoteName('fecha') . ' DESC')
            ->setLimit(20);
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadObjectList();
        
    }  
    ////////////////////////////////////////////////////////////////////////////
    // Get Is Blocked Domain
    ////////////////////////////////////////////////////////////////////////////
    public function getIsBlockedDomain($email)
    {
        // Get Domain.
        $domain = explode("@",trim($email));
        if (count($domain) > 1) {
            // Obtain a database connection
            $db = JFactory::getDbo();
            // Retrieve the shout
            $query = $db->getQuery(true)
                ->select(array('count(id)'))
                ->from($db->quoteName('#__dominios_bloqueados'))                
                ->where($db->quoteName('dominio') ." LIKE '%".$domain[1]."%'")
                ->where($db->quoteName('estado') ." = 1");
            // Prepare the query
            $db->setQuery($query);
            //echo "<br />".$query;
            // Load the row.
            return $db->loadResult();
        }
        // return 0.
        return 0;
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get Count Quotation
    ////////////////////////////////////////////////////////////////////////////
    public function getCountQuotation($id) {
        // Obtain a database connection
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
            ->select(array('COUNT(id) AS cantidad'))
            ->from($db->quoteName('#__cotizacion'))
            ->where($db->quoteName('id_usuario') ." = ".(int)$id)
            ->where($db->quoteName('fecha') ." >= ".$db->quote('2014-10-14'));
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        return $db->loadResult();        
    }    
    ////////////////////////////////////////////////////////////////////////////
    // Get String Date.
    ////////////////////////////////////////////////////////////////////////////
    public function getStringDate($date) {
        $stdate = strtotime($date);
        $mdate = $this->getStringMonth(date("m",$stdate));
        $ddate = $this->getStringDayWeek(date("N",$stdate));
        return $ddate." ".date("d",$stdate)." de ".$mdate." del ".date("Y",$stdate);
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get String Month.
    ////////////////////////////////////////////////////////////////////////////
    public function getStringMonth($month) {
        switch ((int)$month) {
            case 1: return "Enero";
            case 2: return "Febrero";
            case 3: return "Marzo";
            case 4: return "Abril";
            case 5: return "Mayo";
            case 6: return "Junio";
            case 7: return "Julio";
            case 8: return "Agosto";
            case 9: return "Septiembre";
            case 10: return "Octubre";
            case 11: return "Noviembre"; 
            case 12: return "Diciembre"; 
            default: return "";        
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // Get String Day Week.
    ////////////////////////////////////////////////////////////////////////////
    public function getStringDayWeek($day) {
        switch ((int)$day) {
            case 1: return "Lunes";
            case 2: return "Martes";
            case 3: return "Miercoles";
            case 4: return "Jueves";
            case 5: return "Viernes";
            case 6: return "Sábado";
            case 7: return "Domingo";
            default: return "";        
        }
    }
}