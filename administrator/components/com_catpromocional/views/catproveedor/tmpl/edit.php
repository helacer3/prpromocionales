<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
//echo $this->baseurl.'administrator/components/com_catpromocional/media/css/default.css';exit;
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/css/default.css');
?>
<form action="<?php echo JRoute::_('index.php?option=com_catpromocional&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend class="PRtitle"><?php echo JText::_('COM_CATPROMOCIONAL_CATPROMOCIONAL_CATPROVEEDORESDETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $key => $field): 
                                    //echo "<pre>"; var_dump($field); echo "</pre>";?>
                        <div class="control-group">
                            <div class="control-label PRlegend"><?php echo $field->label; ?></div>
                            <div class="controls">
                                <?php 
                                    if ($key === "jform_id" && $field->value > 0)
                                        $field->readonly="true";
                                    echo $field->input; 
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="catpromocional.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>