<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
$path = "index.php?option=com_catpromocional&view=catescala&layout=edit&id=";
$pathPublic = "index.php?option=com_catpromocional&task=catescala.chInfo&id=";
// Include model CatEscalas.
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/models/catescalas.php');
$model = new CatPromocionalModelCatEscalas;
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
                    <?php echo $item->nombre_tipo; ?>
		</td>
		<td>
                    <ul>
                    <?php 
                    $categories = $model->getScaleCategories($item->id);
                    foreach($categories as $categorie) {
                        echo "<li>".$categorie->nombre."</li>";
                    }
                    ?>
                    </ul>
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