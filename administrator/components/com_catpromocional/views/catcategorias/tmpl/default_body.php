<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$cont=1;
$path = "index.php?option=com_catpromocional&view=catcategoria&layout=edit&id=";
$pathPublic = "index.php?option=com_catpromocional&task=catcategoria.chInfo&id=";
$model = $this->getModel();
ListaCategorias($this->baseurl,$path,$pathPublic,$model,0,$cont);
?>
<?php //foreach($this->items as $i => $item): 
function ListaCategorias($url,$path,$pathPublic,$model,$id,&$cont) {
    $categorias = $model->getListQuerySQL($id);
    foreach($categorias as $i => $item):
?>
	<tr class="<?php if($cont % 2 == 0) echo "PRregisters_reporte"; else echo "PRregisters_reporteB"; $cont++;?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
                    <a href="<?php echo $path.$item->id; ?>" 
                    class="<?php echo $item->categoria_padre == 0 ? "catprincipal":"catsecundaria"; ?>">
			<?php echo $item->nombre; ?>
                    </a>
		</td>
		<td>
			<?php echo $item->descripcion; ?>
		</td>
		<td>
			<?php echo $item->cat_padre == "" ? "---" : $item->cat_padre; ?>
		</td>
		<td>
                        <?php $item->estado == 1? $pb=0: $pb=1; ?>
                        <a href="<?php echo $pathPublic.$item->id."&pb=".$pb; ?>">
			<?php 
                        if ($item->estado == 1)
                            echo "<img src='".$url.'/components/com_catpromocional/media/images/tick.png'."' />";
                        else
                            echo "<img src='".$url.'/components/com_catpromocional/media/images/publish_x.png'."' />";
                        ?>
                        </a>
		</td>
	</tr>
<?php
        // Hago auto llamado.
        ListaCategorias($url,$path,$pathPublic,$model,$item->id,$cont);
    endforeach; 
}
?>