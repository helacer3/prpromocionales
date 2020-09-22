<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
// Order Fields.
if (@trim($_GET['ord']) == 'ASC') $order = "DESC"; else $order = "ASC";
?>
<tr class="PRtitle_reporte">
    <td colspan="9">
        Filtros de Búsqueda:
    </td>
</tr>
<tr>
    <td colspan="6">
        <form action="index.php" method="post">
            <input type="hidden" name="view" value="catcosproductos" />
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 385px; margin: 7px 1px" 
            placeholder="Sku producto o escala"/>
            <input type="submit" value="Buscar" class="btn btn-small btn-success">
        </form>
    </td>
    <td>
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="7%">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="7%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTOID'); ?>
		</a>
	</td>
	<td width="17%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTOSKU'); ?>
		</a>
	</td>
	<td width="17%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTOESCALA'); ?>
		</a>
	</td>
	<td width="17%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTORANINICIAL'); ?>
		</a>
	</td>
	<td width="17%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTORANFINAL'); ?>
		</a>
	</td>
	<td width="17%">
		<a href="index.php?option=com_catpromocional&view=catcosproductos&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_CPRODUCTOVALOR'); ?>
		</a>
	</td>
</tr>