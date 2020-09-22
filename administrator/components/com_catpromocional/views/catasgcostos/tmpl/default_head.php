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
            <input type="hidden" name="view" value="catasgcostos" />
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 385px; margin: 7px 1px" 
            placeholder="Técnica o Costo Fijo"/>
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
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGTECNICA'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGCOSTOFIJO'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGRANINICIAL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGRANFINAL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=6&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGTIPOCOSTO'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGTIPOPRECIO'); ?>
		</a>
	</td>
        <td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGVALOR'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catasgcostos&c=9&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_ASGESTADO'); ?>
		</a>
	</td>
</tr>