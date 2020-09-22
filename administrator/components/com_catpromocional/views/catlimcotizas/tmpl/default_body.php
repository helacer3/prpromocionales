<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$path = "index.php?option=com_catpromocional&view=catlimcotiza&layout=edit&id=";
$pathPublic = "index.php?option=com_catpromocional&task=catlimcotiza.chInfo&id=";
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
			<?php echo $item->usuario; ?>
                    </a>
		</td>
		<td>
                    <?php echo $item->nombre; ?>
		</td>
		<td>
                    <?php echo $item->empresa; ?>
		</td>
		<td>
                    <?php echo $item->categoria; ?>
		</td>
		<td>
                    <?php echo $item->cantidad_actual; ?>
		</td>
		<td>
                    <?php echo $item->cantidad_total; ?>
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