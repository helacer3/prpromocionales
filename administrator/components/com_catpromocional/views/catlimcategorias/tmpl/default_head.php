<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
?>
<tr class="PRtitle_reporte">
    <td colspan="5" style="text-align: right;">
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50px">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="70px">
		<?php echo JText::_('COM_CATPROMOCIONAL_LCID'); ?>
	</td>
	<td width="35%">
		<?php echo JText::_('COM_CATPROMOCIONAL_LCNOMBRE'); ?>
	</td>
	<td width="35%">
		<?php echo JText::_('COM_CATPROMOCIONAL_LCDESCRIPCION'); ?>
	</td>
	<td width="25%">
		<?php echo JText::_('COM_CATPROMOCIONAL_LCCANTIDAD'); ?>
	</td>
</tr>