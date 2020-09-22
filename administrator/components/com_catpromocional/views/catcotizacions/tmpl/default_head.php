<?php
// No direct access to tdis file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
$relModal = "{handler: 'ajax', size: {x: 800, y: 550}}";
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
            <input type="hidden" name="view" value="catcotizacions" />
            <input type="text" name="tx_prdfiltro" id="tx_prdfiltro" 
            style="width: 285px; margin: 7px 1px" 
            placeholder="Nombre cliente, email cliente, comentario"
            value="<?php echo $_POST['tx_prdfiltro']; ?>" />

            Cotizaciones hechas desde: 
            <?php 
 				echo JHTML::calendar(
 					(isset($_POST['tx_prdfecini']))?$_POST['tx_prdfecini']:date('Y-01-01'),
 					'tx_prdfecini','tx_prdfecini','%Y-%m-%d');
            ?>
        	hasta:
        	<?php 
 				echo JHTML::calendar(
 					(isset($_POST['tx_prdfecfin']))?$_POST['tx_prdfecfin']:date('Y-m-d'),
 					'tx_prdfecfin','tx_prdfecfin','%Y-%m-%d');
            ?>           
            <input type="submit" id="btn_filcotiza" value="Buscar" class="btn btn-small btn-success">
            <input type="button" id="btn_genxlscotiza" value="Generar XLS" class="btn btn-small btn-success">
        </form>
    </td>
    <td>
		<?php echo $this->pagination->getLimitBox();  ?>
	</td>
</tr>
<tr class="PRtitle_reporte">
	<td width="5%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=1&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAID'); ?>
		</a>
	</td>
	<td width="5%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=2&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAUID'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZANOMBRE'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=3&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAEMPRESA'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=4&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAUEMAIL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=5&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZACOMENTARIO'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=6&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZACEMAIL'); ?>
		</a>
	</td>
	<td width="15%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=7&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZATLEAD'); ?>
		</a>
	</td>
	<td width="10%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAFECHA'); ?>
		</a>
	</td>
	<td width="10%">
		<a href="index.php?option=com_catpromocional&view=catcotizacions&c=8&ord=<?php echo $order; ?>" >
			<?php echo JText::_('COM_CATPROMOCIONAL_COTIZAESTADO'); ?>
		</a>
	</td>
</tr>