<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
	<td width="50">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="70">
		<a href="index.php?option=com_catpromocional&view=catcategorias&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CATEGORIAID'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catcategorias&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CATEGORIANOMBRE'); ?>
		</a>
	</td>
	<td width="30%">
		<a href="index.php?option=com_catpromocional&view=catcategorias&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CATEGORIADESCRIPCION'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catcategorias&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CATEGORIACATPADRE'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catcategorias&c=6&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CATEGORIAESTADO'); ?>
		</a>
	</td>
</tr>