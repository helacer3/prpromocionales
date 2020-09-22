<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
    <td colspan="6" style="text-align: right;">
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="10%">
		<a href="index.php?option=com_catpromocional&view=catunidads&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_UNIDADID'); ?>
		</a>
	</td>
	<td width="30%">
		<a href="index.php?option=com_catpromocional&view=catunidads&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_UNIDADTECNICA'); ?>
		</a>
	</td>
	<td width="25%">
		<a href="index.php?option=com_catpromocional&view=catunidads&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_UNIDADCANTIDAD'); ?>
		</a>
	</td>
	<td width="30%">
		<a href="index.php?option=com_catpromocional&view=catunidads&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_UNIDADNOMBRE'); ?>
		</a>
	</td>
	<td width="5%">
		<a href="index.php?option=com_catpromocional&view=catunidads&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_UNIDADESTADO'); ?>
		</a>
	</td>
</tr>