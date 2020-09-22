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
                <?php echo $item->id; ?>
        </td>
        <td>
                <?php echo $item->producto; ?>
        </td>
        <td>
                <?php echo $item->escala; ?>
        </td>
        <td>
                <?php echo $item->rango_inicial; ?>
        </td>
        <td>
                <?php echo $item->rango_final; ?>
        </td>
        <td>
                <?php echo $item->tipo_precio; ?>
        </td>
        <td>
                <?php echo number_format($item->valor,0,",","."); ?>
        </td>
    </tr>
<?php endforeach; ?>