<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * CatPromocional View
 */
class CatPromocionalViewCatCotizacion extends JViewLegacy
{
	/**
	 * display method of Cat view
	 * @return void
	 */
	public function display($tpl = null) 
        {
            // Set the toolbar
            $this->addToolBar();
            // Display the template
            parent::display($tpl);
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() {
            JToolBarHelper::title(JText::_('COM_CATPROMOCIONAL_MANAGER_COTIZACION_VIEW'), 'catdominio');
	}
}