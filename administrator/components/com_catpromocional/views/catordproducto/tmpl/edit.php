<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
//echo $this->baseurl.'administrator/components/com_catpromocional/media/css/default.css';exit;
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/css/default.css');
$document->addStyleSheet('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
$document->addScript($this->baseurl.'/components/com_catpromocional/media/plugin/jquery/jquery-1.12.2.min.js');
$document->addScript($this->baseurl.'/components/com_catpromocional/media/plugin/jquery/jquery-ui.js');
$document->addScriptDeclaration("
    $(function() {
        $('.rad_order').on('change', function() {
            var val = $(this).val();
            if (val == 3) {
                $('#sortable').show();
            } else {
                $('#sortable').hide();
            }
            $.ajax({
                url : 'index.php?format=raw&option=com_catpromocional&task=setOrderProducts',
                type: 'POST',
                data: { val: val },
                success: function(response) {
                    alert('Se asignó el criterio para el orden de los productos correctamente');
                }
            });
        });
        $('#sortable').sortable({
            placeholder: 'ui-state-highlight',
            opacity: 0.6,
            axis: 'y',
            update: function (event, ui) {
                var postData = $(this).sortable('serialize');
                $.ajax({
                    url : 'index.php?format=raw&option=com_catpromocional&task=sortProviders',
                    type: 'POST',
                    data: postData,
                    success: function(response) {
                        alert('Se ordenaron los proveedores correctamente');
                    }
                });
            }
        });
        $('#sortable').disableSelection();
        // Show default.
        if($('#crt_ordenamiento_3').is(':checked')) {
            $('#sortable').show();           
        }
    });
");
?>
<form action="<?php echo JRoute::_('index.php?option=com_catpromocional&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <div class="control-label PRlegend ">
                            Ordenar Alfab&eacute;ticamente
                        </div>
                        <div class="controls">
                            <input type="radio" name="crt_ordenamiento" id="crt_ordenamiento_1" value="1" class="rad_order" 
                            <?php echo ((int)$this->srtCriteria == 1)?" checked":""; ?> >
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label PRlegend">
                            Ordenar Por más Visitados
                        </div>
                        <div class="controls">
                            <input type="radio" name="crt_ordenamiento" id="crt_ordenamiento_2" value="2" class="rad_order"
                            <?php echo ((int)$this->srtCriteria == 2)?" checked":""; ?> >
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label PRlegend">
                            Ordenar Por Proveedor
                        </div>
                        <div class="controls">
                            <input type="radio" name="crt_ordenamiento" id="crt_ordenamiento_3" value="3" class="rad_order"
                            <?php echo ((int)$this->srtCriteria == 3)?" checked":""; ?> >
                        </div>
                        <div class="controls">
                            <ul id="sortable">
                                <?php foreach ($this->providers as $provider ) { ?>
                                <li class="ui-state-default" id="prv_<?php echo $provider->id; ?>">
                                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                    <?php echo $provider->nombre; ?>
                                </li>
                                <?php } ?>
                            </ul>                          
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="catpromocional.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>