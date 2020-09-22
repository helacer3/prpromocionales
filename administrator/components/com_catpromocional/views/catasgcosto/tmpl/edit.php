<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$scriptJs = "
    jQuery(document).ready(function(){
        jQuery('#jform_id_escala').on('change', function() {
            var id = jQuery(this).val();
            jQuery.ajax({
                url : 'index.php?format=raw&option=com_catpromocional&task=getScaleRanges',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    //alert(response);
                    jQuery('#jform_id_escala_rango').empty().append(response);
                }
            });
        });
        if(parseInt(jQuery('#jform_id_escala').val()) > 0) {
            jQuery('#jform_id_escala').trigger('change');
        }
    });";
$document->addScriptDeclaration($scriptJs);
//echo $this->baseurl.'administrator/components/com_catpromocional/media/css/default.css';exit;
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/css/default.css');
?>
<form action="<?php echo JRoute::_('index.php?option=com_catpromocional&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend class="PRtitle"><?php echo JText::_('COM_CATPROMOCIONAL_CATPROMOCIONAL_ASGCOSDETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $key => $field): ?>
                        <div class="control-group">
                            <div class="control-label <?php if ($key !="jform_id") echo "PRlegend"; ?>"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="catpromocional.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>