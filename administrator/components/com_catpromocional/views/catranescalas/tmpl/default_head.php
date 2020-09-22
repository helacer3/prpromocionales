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
	<td width="70px">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="100px">
		<a href="index.php?option=com_catpromocional&view=catranescalas&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_RESCALAID'); ?>
		</a>
	</td>
	<td width="25%">
		<a href="index.php?option=com_catpromocional&view=catranescalas&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_RESCALANESCALA'); ?>
		</a>
	</td>
	<td width="25%">
		<a href="index.php?option=com_catpromocional&view=catranescalas&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_RESCALARINICIAL'); ?>
		</a>
	</td>
	<td width="25%">
		<a href="index.php?option=com_catpromocional&view=catranescalas&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_RESCALARFINAL'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catranescalas&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_RESCALAESTADO'); ?>
		</a>
	</td>
</tr>