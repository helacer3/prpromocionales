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
            <input type="hidden" name="view" value="catlimcotizas" />
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 385px; margin: 7px 1px" 
            placeholder="Nombre, Empresa, Correo o Categoría"/>
            <input type="submit" value="Buscar" class="btn btn-small btn-success">
        </form>
    </td>
    <td>
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="50">
		<?php echo JHtml::_('grid.checkall'); ?>
	</td>
	<td width="100px">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOID'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOUSUARIO'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCONOMBRE'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOEMPRESA'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOCATEGORIA'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOCANACTUAL'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=6&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_LCOCANTOTAL'); ?>
		</a>
	</td>
	<td width="12%">
		<a href="index.php?option=com_catpromocional&view=catlimcotizas&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_DOMINIOESTADO'); ?>
		</a>
	</td>
</tr>