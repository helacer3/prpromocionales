<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * CatPromocional View
 */
class CatPromocionalViewCatOrdproducto extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var		form
	 */
	protected $form = null;
 
	/**
	 * display method of Cat view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form        = $this->get('Form');
		$item        = $this->get('Item');
		$providers   = $this->get('Providers');
		$srtCriteria = $this->get('SorterCriteria');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form        = $form;
		$this->item        = $item;
		$this->providers   = $providers;
		$this->srtCriteria = $srtCriteria;

		//var_dump($providers);
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{		
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title(JText::_('COM_CATPROMOCIONAL_MANAGER_CORDPRODUCTOS_NEW'), 'catordproducto');
		//JToolBarHelper::save('catordproducto.save');
		JToolBarHelper::cancel('catpromocional.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_CATPROMOCIONAL_MANAGER_CORDPRODUCTOS_NEW'));
	}
}