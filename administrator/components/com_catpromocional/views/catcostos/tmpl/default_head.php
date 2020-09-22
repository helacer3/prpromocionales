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
	<td width="100px">
		<a href="index.php?option=com_catpromocional&view=catcostos&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COSTOFIJOID'); ?>
		</a>
	</td>
	<td width="30%">
		<a href="index.php?option=com_catpromocional&view=catcostos&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COSTOFIJONOMBRE'); ?>
		</a>
	</td>
	<td width="30%">
		<a href="index.php?option=com_catpromocional&view=catcostos&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COSTOFIJOESCALA'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catcostos&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COSTOFIJOCNTEXCLUYE'); ?>
		</a>
	</td>
	<td width="10%">
		<a href="index.php?option=com_catpromocional&view=catcostos&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COSTOFIJOESTADO'); ?>
		</a>
	</td>
</tr>