<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (@trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
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
	<td width="70">
		<a href="index.php?option=com_catpromocional&view=catescalas&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ESCALAID'); ?>
		</a>
	</td>
	<td width="35%">
		<a href="index.php?option=com_catpromocional&view=catescalas&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ESCALANOMBRE'); ?>
		</a>
	</td>
	<td width="35%">
		<a href="index.php?option=com_catpromocional&view=catescalas&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ESCALATIPO'); ?>
		</a>
	</td>
	<td width="35%">
		<?php echo JText::_('COM_CATPROMOCIONAL_ESCALACATEGORIAS'); ?>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catescalas&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ESCALAESTADO'); ?>
		</a>
	</td>
</tr>