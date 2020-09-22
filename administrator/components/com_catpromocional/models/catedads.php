<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatEdads extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
        $jinput = JFactory::getApplication()->input;
        // Obtengo parametros de ordenamiento.
        $field = $jinput->get('c', '1', 'integer');
        $order = $jinput->get('ord', 'ASC', 'string');
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the categoria table
 		$query = "SELECT nombre,sku,fec_creacion
                FROM #__producto ORDER BY ".$field." ".$order;
		return $query;
	}
    /*****************************************************/
    private function getDiasBisiesto($AInicio,$AFinal) {
        $suma = 0;
        for ($i = $AInicio; $i <= $AFinal; $i++) {
            (($i % 4) == 0) ? $bis = 86400 : $bis = 0;
            $suma += $bis;
        }
        return $suma;
    }
    /*****************************************************/
    public function CalculaEdad($fecIni) {
        // Creo arreglo.
        $datos = array();
        // Comprobamos si hay algún año bisiesto. 86400 segundos es un dias
        $fInicio = date("Y/m/d",strtotime($fecIni));
        $fFinal = date("Y/m/d");
        $AInicio = date("Y",strtotime($fecIni));
        $AFinal = date("Y");
        $sumadiasBis = $this->getDiasBisiesto($AInicio,$AFinal);
        // Calculamos los segundos entre las dos fechas
        $fechaInicio = strtotime($fInicio);
        $fechaFinal = strtotime($fFinal);
        $segundos = ($fechaFinal - $fechaInicio);
        $datos['anos'] = floor(($segundos-$sumadiasBis)/31536000);
        //echo $anyos. " a&ntilde;os<br />";
        $segundosRestante = ($segundos-$sumadiasBis)%(31536000);
        $datos['meses'] = floor($segundosRestante/2592000);
        //echo $meses. " meses<br />";
        $segundosRestante = ($segundosRestante%2592000); // Suma un día mas por cada años bisiesto
        //$segundosRestante = (($segundosRestante-$sumadiasBis)%2592000); // No suma un día mas por cada año bisiesto
        $datos['dias'] = floor($segundosRestante/86400);
        //echo $dias. " d&iacute;as<br />";
        return $datos;
    } 
    /*****************************************************/
}