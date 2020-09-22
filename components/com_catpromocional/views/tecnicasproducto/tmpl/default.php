<?php
defined('_JEXEC') or die;
// Require model filters.
require_once(JPATH_BASE.'/modules/mod_prdfilters/helper.php' );
// Get Model Prdfilters.
$ttpTechnique = "<div id='cnt_ttptechnique'>";
$ttpUnidad = "<div id='cnt_ttpunit'>";
$techniques = ModPrdFiltersHelper::getTechniquesByProduct($this->productid);
// Generate Tooltip Techniques.
foreach($techniques as $technique) {
    if ($technique->descripcion != "" && $technique->path != "") {
        $ttpTechnique .= "<div id='ttptitle'>";
        $ttpTechnique .= $technique->nombre;
        $ttpTechnique .= "</div>";
        $ttpTechnique .= "<div id='ttpimage'>";
        $ttpTechnique .= "<img src='".JURI::root().$technique->path."' />";
        $ttpTechnique .= "</div>";
        $ttpTechnique .= "<div id='ttpdesc'>";
        $ttpTechnique .= $technique->descripcion;
        $ttpTechnique .= "</div>";        
        $ttpUnidad .= "<div class='ttptitle ttptitle_".$technique->id."'>";
        $ttpUnidad .= "Unidades de: ".$technique->nombre;
        $ttpUnidad .= "</div>";
        $ttpUnidad .= "<div class='cnt_ttpunit cnt_ttpunit_".$technique->id."'>";
        $ttpUnidad .= $technique->descripcion_unidad;
        $ttpUnidad .= "</div>";
    }
}
$ttpTechnique .= "</div>";
$ttpUnidad .= "</div>";
?>
<tr class="trdinamica">
    <td></td>
    <td>
    </td>
    <td>
    </td>
</tr>
<tr>
    <td colspan="3" align="center" style="padding-bottom:10px;">
        ¿Con qu&eacute; t&eacute;cnica de marcación desea sus logos?
    </td>
</tr>
<?php
// Loop According to Cantity.
for ($c = 1; $c <= $this->cantidad; $c++) {
    // generate select technique.        
    $seltechniques = ModPrdFiltersHelper::getSelectGenerated($techniques,
        'prd_tecnica['.$c.']','prd_tecnica_'.$c,'T&eacute;cnicas','prdtecnicas',1);
?>
    <tr class="trdinamica">	
        <td>Logo <?php echo $c; ?></td>
        <td>                        
            <?php
            // Show select
            echo $seltechniques;
            // Validate show tooltip.
            if ($c == 1) {
            ?>            
            <a id="ttp_technique" class="fa fa-info-circle lnk_tooltip" 
            aria-hidden="true" title=""></a>
            <span class="cnt_ttp_technique"><?php echo $ttpTechnique; ?></span> 
            <?php } else { echo "<a class='lnk_tooltip'></a>"; } ?>         
        </td>	
        <td>                        
            <?php
            // Validate show tooltip.
            if ($c == 1) {
            ?>  
            <a id="ttp_unidad" class="fa fa-info-circle lnk_tooltip" 
            aria-hidden="true" title=""></a>
            <span class="cnt_ttp_unit"><?php echo $ttpUnidad; ?></span>
            <?php } else { echo "<a class='lnk_tooltip'></a>"; } ?>          

            <select name="prd_unidad[<?php echo $c; ?>]" id="prd_unidad_<?php echo $c; ?>">
                    <option value="">Unidad</option>
            </select>	
        </td>	
    </tr>
<?php
}
?>