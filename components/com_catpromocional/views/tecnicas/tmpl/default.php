<?php
defined('_JEXEC') or die;
// Require model filters.
require_once(JPATH_BASE.'/modules/mod_prdfilters/helper.php' );
// Get Model Prdfilters.
$techniques = ModPrdFiltersHelper::getTechniques();
// Loop According to Cantity.
for ($c = 0; $c < $this->cantidad; $c++) {
?>
    <div id="selectores">                        
        <?php
        // generate select technique.        
        $seltechniques = ModPrdFiltersHelper::getSelectGenerated($techniques,
            'flt_tecnica['.$c.']','flt_tecnica_'.$c,'T&eacute;cnicas','seleccionar seltecnicas',1);
        // Show select
        echo $seltechniques;
        ?>
        <select name="flt_unidad[<?php echo $c; ?>]" id="flt_unidad_<?php echo $c; ?>" class="seleccionar">
                <option value="">Unidad</option>
        </select>
    </div>
<?php
}
?>