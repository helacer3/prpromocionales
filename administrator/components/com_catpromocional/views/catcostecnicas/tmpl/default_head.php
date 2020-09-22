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
    <td colspan="8">
        <form action="index.php" method="post">
            <input type="hidden" name="view" value="catcostecnicas" />
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 385px; margin: 7px 1px" 
            placeholder="Nombre producto, técnica o unidad"/>
            <input type="submit" value="Buscar" class="btn btn-small btn-success">
        </form>
    </td>
    <td>
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="5%">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="20%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTPRODUCTO'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTTECNICA'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTUNIDAD'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTRANINICIAL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=6&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTRANFINAL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTTIPOPRECIO'); ?>
		</a>
	</td>
        <td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTVALOR'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcostecnicas&c=9&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_PRTESTADO'); ?>
		</a>
	</td>
</tr>