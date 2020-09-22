<?php
error_reporting(E_ALL);
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// Call Model.
require_once JPATH_COMPONENT_ADMINISTRATOR.'/models/catcotizacions.php'; 
$model = new CatPromocionalModelCatCotizacions;
// get Quotation States.
$quoStates = $model->getQuotationStates();
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="<?php if($i % 2 == 0) echo "PRregisters_reporte"; else echo "PRregisters_reporteB";?> row<?php echo $i % 2; ?>">
		<td>
            <?php echo $item->id; ?>
		</td>
		<td>
            <?php echo $item->user_id; ?>
		</td>
		<td>                    
            <a href="index.php?option=com_catpromocional&task=catcotizacion.show&id=<?php echo $item->id; ?>" rel="<?php echo $relModal; ?>" class="modal">
                <?php echo $item->nombre; ?>
            </a>
		</td>
		<td>
            <?php echo $item->company; ?>
		</td>
		<td>
            <?php echo $item->email; ?>
		</td>
		<td>
            <?php echo $item->comentario; ?>
		</td>
		<td>
            <?php echo $item->email_cliente; ?>
		</td>
		<td>
            <?php echo $item->tipo_lead; ?>
		</td>
		<td>
            <?php echo date("Y-m-d H:i:s",strtotime($item->fecha)); ?>
		</td>
		<td>
            <form>
            	<table>
            		<?php foreach ($quoStates as $qstate) { ?>
        			<tr>
            			<td>
							<?php
								echo "<img src='".$this->baseurl.'/components/com_catpromocional/media/images/'.
									$qstate->imagen."' style='width: 20px; height; 20px;' />"; 
							?>
	            			<input type="radio" name="est_cotiza" id="est_cotiza_<?php echo $item->id; ?>" 
	            			title="<?php echo $qstate->nombre; ?>" class="chk_cstate"
	            			value="<?php echo $qstate->id; ?>" 
	            			<?php echo ($qstate->id == $item->id_estado_cotizacion)?"checked":""; ?> >
            			</td>
        			</tr>
        			<?php } ?>
            	</table>
            </form>
		</td>

	</tr>
<?php endforeach; ?>