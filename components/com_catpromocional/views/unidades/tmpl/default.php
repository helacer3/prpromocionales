<?php
defined('_JEXEC') or die;
// Require model filters.
require_once(JPATH_BASE.'/modules/mod_prdfilters/helper.php' );
// Get Model Prdfilters.
$units = ModPrdFiltersHelper::getUnitsTechnique($this->id);
// generate select units.        
$selunits = ModPrdFiltersHelper::getSelectGenerated($units,
    'flt_tecnica['.$this->id.']','flt_tecnica_'.$this->id,'Unidad','seleccionar',2);
// Show select
echo $selunits;
?>
