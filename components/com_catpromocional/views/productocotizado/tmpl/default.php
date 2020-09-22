<?php
defined('_JEXEC') or die;
// Get general Model.
require_once JPATH_COMPONENT_SITE. '/models/generals.php';
?>
<div id="nombre-producto"><h1>Productos en su cotización</h1></div>
<div id="titulos-cantidad">
    <div class="cont-tabla-cotiza">
        <div class="titulo-cantidad">Nombre</div>
    </div>
    <div class="cont-tabla-cotiza">
        <div class="titulo-cantidad">Cantidad</div>
    </div>
    <div class="cont-tabla-cotiza">
        <div class="titulo-logo">Logo</div>
    </div>
    <div class="cont-tabla-cotiza">
        <div class="titulo-tecnica">Técnica</div>
    </div>
    <div class="cont-tabla-cotiza">
        <div class="titulo-unidad">Unidad</div>
    </div>
    <div class="cont-tabla-cotiza">
        <div class="titulo-unidad">Eliminar</div>
    </div>
</div>
<!-- Show products Add -->
<?php 
if (count($this->sesproducts) > 0) {
    foreach($this->sesproducts as $key => $product) { ?>
<!--producto con cantidad 1-->
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">                      
    <div class="item-tabla"><?php echo CatpromocionalModelGenerals::getFormatString($product['namproduct']); ?></div>
</div>
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">                    	
    <div class="item-tabla"><?php echo $product['cntproduct']; ?></div>
</div>
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">
    <div class="item-tabla">
        <?php foreach($product['logo'] as $logo) {  
            echo $logo['nombre']."<br />";
        } ?>
    </div>
</div>
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">
    <div class="item-tabla">
        <?php foreach($product['logo'] as $logo) {  
            echo CatpromocionalModelGenerals::getFormatString($logo['tecnicanombre'])."<br />";
        } ?>
    </div>
</div>
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">
    <div class="item-tabla">
        <?php foreach($product['logo'] as $logo) {  
            echo CatpromocionalModelGenerals::getFormatString($logo['unidadnombre'])."<br />";
        } ?>
    </div>
</div>
<div class="cont-tabla-cotiza cont-tabla-<?php echo $key; ?>">
    <div class="item-tabla">
       <a id="<?php echo $key; ?>" class="fa fa-trash btn_rmvcart" aria-hidden="true"></a>
    </div>
</div>
<?php 
    }
} 
?>
<div id="agregar-cotizacion">        
    <a id="lnk_agrcotiza" href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=addquser&id='.$this->productid); ?>">
        <div>FINALIZAR COTIZACIÓN</div>
    </a>
</div>
<?php
?>