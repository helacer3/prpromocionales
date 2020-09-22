<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CatPromocionalList Model
 */
class CatPromocionalModelCatTcotizas extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the categoria table
		$query
		    ->select('id,introduccion,estado,terminos,footer,correo_destino1,'
                    . 'correo_destino2,correo_destino3,correo_destino4,'
                    . 'correo_destino5,correo_destino6,correo_destino7,correo_destino8')
		    ->from('#__textocotizacion');
		return $query;
	}
}