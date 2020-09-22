<?php
defined('_JEXEC') or die;
// Add JS.
$document = JFactory::getDocument();
$document->addScriptDeclaration("");
// Get general Model.
require_once JPATH_BASE. '/components/com_catpromocional/models/generals.php';
// Validate exist array info.
if (count($this->lstproducts)) {
?>
    <h2 class="titulo-carrito">Productos de su cotización</h2> 
<?php
    foreach ($this->lstproducts as $key => $product) {
        //echo "<br /><pre>"; var_dump($product); echo "</pre><br />";
    ?>
    <div class="producto-carrito producto-carrito-<?php echo $key; ?>">
        <img class="prd-carro" src="<?php echo JURI::root()."images/catalog/products/thumbnails/".
            end(@explode('/',$product['imgproduct'])); ?>">
        <p class="texto-producto-carro">
            <a href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=getproduct&id='.$product['idproduct']); ?>">
                <?php 
                    echo "<b>".$product['cntproduct']."</b> X ".CatpromocionalModelGenerals::getFormatString($product['namproduct']).
                        " (".count($product['logo'])." logos) "; 
                ?>
            </a>
        </p>
    </div> 
    <?php } ?>
<h2 id="finalizar-cotizacion-carro">
    <a href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=getconfirm'); ?>">Finalizar cotización</a>
</h2>
<?php } ?>