<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="<?php if($i % 2 == 0) echo "PRregisters_reporte"; else echo "PRregisters_reporteB";?> row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->introduccion; ?>
		</td>
		<td>
			<?php echo $item->estado; ?>
		</td>
		<td>
			<?php echo $item->terminos; ?>
		</td>
		<td>
			<?php echo $item->footer; ?>
		</td>
		<td>
			<table>
				<tr><td><?php echo $item->correo_destino1; ?></td></tr>
				<tr><td><?php echo $item->correo_destino2; ?></td></tr>
				<tr><td><?php echo $item->correo_destino3; ?></td></tr>
				<tr><td><?php echo $item->correo_destino4; ?></td></tr>
				<tr><td><?php echo $item->correo_destino5; ?></td></tr>
				<tr><td><?php echo $item->correo_destino6; ?></td></tr>
				<tr><td><?php echo $item->correo_destino7; ?></td></tr>
				<tr><td><?php echo $item->correo_destino8; ?></td></tr>
			</table>
		</td>
	</tr>
<?php endforeach; ?>