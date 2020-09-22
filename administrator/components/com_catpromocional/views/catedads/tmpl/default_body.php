<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// Invoco el modelo.
$model   = $this->getModel();
//echo "<pre>"; var_dump($edad); echo "</pre>";
?>
<?php 
    foreach($this->items as $i => $item): 
        // Obtengo la edad del producto.
        $edad = $model->CalculaEdad($item->fec_creacion);    
?>
	<tr class="<?php if($i % 2 == 0) echo "PRregisters_reporte"; else echo "PRregisters_reporteB";?> row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->nombre; ?>
		</td>
		<td>
			<?php echo $item->sku; ?>
		</td>
		<td>
			<?php echo $item->fec_creacion; ?>
		</td>
		<td align="center">
			<?php echo $edad['anos']; ?>
		</td>
		<td align="center">
			<?php echo $edad['meses']; ?>
		</td>
		<td align="center">
			<?php echo $edad['dias']; ?>
		</td>
        </tr>
<?php endforeach; ?>