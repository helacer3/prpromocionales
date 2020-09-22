<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (@trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
    <td colspan="7" style="text-align: right;">
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50px">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="140px">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTAID'); ?>
		</a>
	</td>
	<td width="31%">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTATITULO'); ?>
		</a>
	</td>
	<td width="31%">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTASUBTITULO'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTAENLACE'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTACATEGORIA'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catofertas&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_OFERTAESTADO'); ?>
		</a>
	</td>
</tr>