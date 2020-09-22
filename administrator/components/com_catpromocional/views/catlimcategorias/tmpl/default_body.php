<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$path = "index.php?option=com_catpromocional&view=catlimcategoria&layout=edit&id=";
$pathPublic = "index.php?option=com_catpromocional&task=catlimcategoria.chInfo&id=";
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
                <?php echo $item->descripcion; ?>
        </td>
        <td>
                <?php echo $item->cantidad; ?>
        </td>
    </tr>
<?php endforeach; ?>