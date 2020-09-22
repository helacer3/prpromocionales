<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
    <td colspan="9">
        Filtros de Búsqueda:
    </td>
</tr>
<tr>
    <td colspan="7">
        <form action="index.php" method="post">
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 385px; margin: 7px 1px" 
            placeholder="Nombre producto o categoría o proveedor"/>
            <input type="submit" value="Buscar" class="btn btn-small btn-success">
        </form>
    </td>
    <td>
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50px">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="100px">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ID'); ?>
		</a>
	</td>
	<td width="40%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_NOMBRE'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_SKU'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=10&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PROVEEDOR'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=11&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRECIO'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PUBLICADO'); ?>
		</a>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catpromocionals&c=9&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ESTADO'); ?>
		</a>
	</td>
</tr>