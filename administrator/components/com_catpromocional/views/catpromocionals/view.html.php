<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * CatPromocionals View
 */
class CatPromocionalViewCatPromocionals extends JViewLegacy
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
		JToolBarHelper::title(JText::_('COM_CATPROMOCIONAL_MANAGER_CATPROMOCIONALS').
		//Reflect number of items in title!
		($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
		, 'catpromocional');
		JToolBarHelper::addNew('catpromocional.add');
		JToolBarHelper::deleteList('¿Está seguro que desea eliminar los registros seleccionados?', 'catpromocionals.delete');
		JToolBarHelper::editList('catpromocional.edit');
        JToolBarHelper::custom('catcproducto.add','new.png','',JText::_('COM_CATPROMOCIONAL_MCRGPRODUCTOS'),false,false);
        JToolBarHelper::custom('catcarcimagen.add','new.png','',JText::_('COM_CATPROMOCIONAL_MCRGARCIMAGENES'),false,false);
        JToolBarHelper::custom('catcimagen.add','new.png','',JText::_('COM_CATPROMOCIONAL_MCRGIMAGENES'),false,false);
        JToolBarHelper::custom('catordproducto.add','new.png','',JText::_('COM_CATPROMOCIONAL_MORDPRODUCTOS'),false,false);
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