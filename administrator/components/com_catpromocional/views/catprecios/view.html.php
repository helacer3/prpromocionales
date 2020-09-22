<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * CatPromocionals View
 */
class CatPromocionalViewCatPrecios extends JViewLegacy
{
	/**
	 * CatPromocionals view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		// Set the toolbar and number of found items
		$this->addToolBar($this->pagination->total);
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar($total=null) 
	{
		JToolBarHelper::title(JText::_('COM_CATPROMOCIONAL_MANAGER_PRECIOS').
		//Reflect number of items in title!
		($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
		, 'catpromocional');
		JToolBarHelper::addNew('catprecio.add');
		JToolBarHelper::deleteList('¿Está seguro que desea eliminar los registros seleccionados?', 'catprecios.delete');
		JToolBarHelper::editList('catprecio.edit');
        JToolBarHelper::custom('catcprecio.add','new.png','',JText::_('COM_CATPROMOCIONAL_MCRGPRECIOS'),false,false);
        JToolBarHelper::custom('catcosproducto.cancel','new.png','',JText::_('COM_CATPROMOCIONAL_MCRGLCOSTOS'),false,false);
        JToolBarHelper::custom('catmarpico.getCatalogue','new.png','',JText::_('COM_CATPROMOCIONAL_CATMARPICO'),false,false);
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_CATPROMOCIONAL_ADMINISTRATION'));
	}
}