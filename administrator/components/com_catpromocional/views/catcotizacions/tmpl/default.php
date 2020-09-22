<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();

$document->addScript($this->baseurl.'/components/com_catpromocional/media/plugin/jquery/jquery-1.12.2.min.js');
$scriptJs = "
    $(document).ready(function(){
        $('#btn_genxlscotiza').on('click', function() {
            var texto  =  $('#tx_prdfiltro').val();
            var fecini =  $('#tx_prdfecini').val();
            var fecfin =  $('#tx_prdfecfin').val();
            $(location).attr('href', 'index.php?option=com_catpromocional&task=catccotizacions.generateOrdersFile&flt_texto='+texto+'&fecini='+fecini+'&fecfin='+fecfin);
        });
        $('.chk_cstate').on('change', function() {
        	var val = $(this).val();
        	var id  = $(this).attr('id');
        	if (confirm('Está segur@ que desea modificar el estado de la orden?')) {
        		$.ajax({
	                data:  {
                		id: id,
                		val: val,
	                },
	                url:   'index.php?option=com_catpromocional&task=catccotizacions.setOrderState',
	                type:  'post',
	                success:  function (response) {}
                });
        	}
    	});
    });";
$document->addScriptDeclaration($scriptJs);




//echo $this->baseurl.'administrator/components/com_catpromocional/media/css/default.css';exit;
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/css/default.css');
?>
<form action="<?php echo JRoute::_('index.php?option=com_catpromocional'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="catcotizacions" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>