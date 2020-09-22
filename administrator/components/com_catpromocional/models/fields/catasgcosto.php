<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * CatPromocional Form Field class for the CatPromocional component
 */
class JFormFieldCatCosto extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'CatPromocional';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id_tecnica_costofijo,id_escala_rangos,id_tipo_costofijo,'
                        . 'id_tipo_precio,valor,estado');
		$query->from('#__tecnica_costofijo_precio');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
                    foreach($messages as $message) 
                    {
                        $options[] = JHtml::_('select.option', $message->id, $message->id_tecnica);
                    }
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}