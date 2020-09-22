<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$path = "index.php?option=com_catpromocional&view=cattecnica&layout=edit&id=";
$pathPublic = "index.php?option=com_catpromocional&task=cattecnica.chInfo&id=";
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="<?php if($i % 2 == 0) echo "PRregisters_reporte"; else echo "PRregisters_reporteB";?> row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<a href="<?php echo $path.$item->id; ?>">
			<?php echo $item->nombre; ?>
			</a>
		</td>
		<td>
			<?php echo $item->nombre_frontend; ?>
		</td>
		<td>
			<?php echo $item->descripcion; ?>
		</td>
		<td>
			<?php echo $item->descripcion_unidad; ?>
		</td>
		<td>
			<?php echo $item->escala; ?>
		</td>
		<td>
			<?php echo $item->tecnica_padre; ?>
		</td>
		<td>
			<?php $item->estado == 1? $pb=0: $pb=1; ?>
				<a href="<?php echo $pathPublic.$item->id."&pb=".$pb; ?>">
				<?php 
				if ($item->estado == 1)
				echo "<img src='".$this->baseurl.'/components/com_catpromocional/media/images/tick.png'."' />";
				else
				echo "<img src='".$this->baseurl.'/components/com_catpromocional/media/images/publish_x.png'."' />";
			?>
		</a>
		</td>
	</tr>
<?php endforeach; ?>