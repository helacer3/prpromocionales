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
    <td colspan="3"></td>
    <td colspan="3" class="PRsbtitle_reporte" >
        <?php echo JText::_('COM_CATPROMOCIONAL_EDADCALCULO'); ?>
    </td>
</tr>
<tr class="PRtitle_reporte">
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catedads&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_EDADNOMBRE'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catedads&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_EDADSKU'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catedads&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_EDADFECHA'); ?>
		</a>
	</td>
	<td width="20%" class="PRsbtitle_reporte">
		<?php echo JText::_('COM_CATPROMOCIONAL_EDADANOS'); ?>
	</td>
	<td width="20%" class="PRsbtitle_reporte">
		<?php echo JText::_('COM_CATPROMOCIONAL_EDADMESES'); ?>
	</td>
	<td width="20%" class="PRsbtitle_reporte">
		<?php echo JText::_('COM_CATPROMOCIONAL_EDADDIAS'); ?>
	</td>
</tr>