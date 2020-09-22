<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
    <td colspan="5" style="text-align: right;">
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="70">
		<a href="index.php?option=com_catpromocional&view=catproveedors&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PROVEEDORID'); ?>
		</a>
	</td>
	<td width="70">
		<a href="index.php?option=com_catpromocional&view=catproveedors&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PROVEEDORNOMBRE'); ?>
		</a>
	</td>
	<td width="45%">
		<a href="index.php?option=com_catpromocional&view=catproveedors&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PROVEEDORABREVIATURA'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catproveedors&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PROVEEDORESTADO'); ?>
		</a>
	</td>
</tr>