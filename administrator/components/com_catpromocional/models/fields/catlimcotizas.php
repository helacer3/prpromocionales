<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * CatPromocional Form Field class for the CatPromocional component
 */
class JFormFieldCatLimcotizas extends JFormFieldList
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
                $query
                    ->select(array('u.id','u.email as usuario','u.name as nombre',
                    'cl.nombre AS categoria','lc.cantidad_actual','lc.cantidad_total','lc.estado',
                    '(SELECT profile_value FROM prp_user_profiles WHERE '
                        . 'user_id = u.id AND profile_key=\'profile.company\' limit 1) as empresa'))
                    ->from($db->quoteName('#__limita_cotizaciones','lc'))                    
                    ->join('LEFT', $db->quoteName('#__users', 'u')
                    . ' ON (' . $db->quoteName('lc.id_usuario') . ' = ' .$db->quoteName('u.id') . ')')                    
                    ->join('LEFT', $db->quoteName('#__categoria_limita', 'cl')
                    . ' ON (' . $db->quoteName('lc.id_categoria_limita') . ' = ' .$db->quoteName('cl.id') . ')')
                    ->order($db->quoteName('lc.id_usuario') . ' ASC');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
                    foreach($messages as $message) 
                    {
                        $options[] = JHtml::_('select.option', $message->id, $message->nombre);
                    }
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}