<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/css/default.css');
$user = JFactory::getUser($this->quotation->id_usuario);
$userProfile = JUserHelper::getProfile($this->quotation->id_usuario);
//var_dump($userProfile);exit;
?>
<div id="contenedor_cotiza">
    <div id="cotiza_header">
        <div id="cotiza_header_logo">
            <img src="<?php echo JURI::root(); ?>images/logo.png" />
        </div>
        <div id="cotiza_header_lateral">
            <div id="cotiza_header_number"><?php echo $this->id; ?></div>
            <div id="cotiza_header_date"><?php echo $this->quotation->fecha; ?></div>            
        </div>
    </div>
    <div id="cotiza_info_client">
        <div class="cotiza_info_content cotiza_info_left">
            <div class="cotiza_info_content_name">Nombre Cliente:</div>
            <div class="cotiza_info_content_value"><?php echo $user->get('name'); ?></div>
            <div class="cotiza_info_content_name">Email Cliente:</div>
            <div class="cotiza_info_content_value"><?php echo $this->quotation->email_cliente; ?></div>
            <div class="cotiza_info_content_name">Empresa:</div>
            <div class="cotiza_info_content_value">
                <?php if (array_key_exists('company', $userProfile->profile)) echo $userProfile->profile['company']; ?>
            </div>
            <div class="cotiza_info_content_name">Pais:</div>
            <div class="cotiza_info_content_value">
                <?php if (array_key_exists('city', $userProfile->profile)) echo $userProfile->profile['country']; ?>
            </div>
            <div class="cotiza_info_content_name">Ciudad:</div>
            <div class="cotiza_info_content_value">
                <?php if (array_key_exists('city', $userProfile->profile)) echo $userProfile->profile['city']; ?>
            </div>
            <div class="cotiza_info_content_name">Tel&eacute;fono:</div>
            <div class="cotiza_info_content_value">
                <?php if (array_key_exists('phone', $userProfile->profile)) echo $userProfile->profile['phone']; ?>
            </div>
            <div class="cotiza_info_content_name">Tel&eacute;fono movil:</div>
            <div class="cotiza_info_content_value">
                <?php if (array_key_exists('phone2', $userProfile->profile)) echo $userProfile->profile['phone2']; ?>
            </div>
        </div>
        <div class="cotiza_info_content cotiza_info_right">
            <div class="cotiza_info_content_cmname">Comentario Cliente: </div>
            <div class="cotiza_info_content_cmvalue"><?php echo $this->quotation->comentario; ?></div>            
        </div>
    </div>
    <div id="cotiza_products">
        <div id="cotiza_products_header">
            <div class="cotiza_products_header_title">Cantidad</div>
            <div class="cotiza_products_header_title">Imagen</div>
            <div class="cotiza_products_header_title">Nombre</div>
            <div class="cotiza_products_header_title">Descripci&oacute;n</div>
            <div class="cotiza_products_header_title">Referencia</div>
            <div class="cotiza_products_header_title">Precio</div>
            <div class="cotiza_products_header_title">Precio M.</div>
            <div class="cotiza_products_header_title">Subtotal</div>
        </div>
        <?php 
            foreach ($this->qitem as $item) { 
                // Set Vars.
                $prcmarca = 0;
                $prclogo = 0;
                $prdInfo = $this->modelp->getProductSingleInfo($item->id_producto);
                // Get Info Logos Item
                $logproduct = $this->modelcq->getQuotationItemLogos($item->id);
                // Loop Logos
                if (count($logproduct) > 0) {
                    foreach ($logproduct as $logo) {
                        // Precio marcacion.
                        $prclogo = $this->modelcq->getPriceMrcLogo($logo,$item);
                        // Precio Marcación.
                        $prcmarca += $prclogo;
                    }
                }
        ?>
        <div id="cotiza_products_item">
            <div class="cotiza_products_item_value"><?php echo $item->cantidad; ?></div>
            <div class="cotiza_products_item_value">
                <a href="<?php echo JURI::root(); ?>index.php/productos/getproduct/<?php echo $item->id_producto; ?>"   target="_blank">
                    <img src="<?php echo JURI::root().'images/catalog/products/thumbnails/'.
                        end(@explode('/',$prdInfo['path'])); ?>" />
                </a>
            </div>
            <div class="cotiza_products_item_value"><?php echo $item->nombre; ?></div>
            <div class="cotiza_products_item_value"><?php echo $item->descripcion; ?></div>
            <div class="cotiza_products_item_value"><?php echo $item->referencia; ?></div>
            <div class="cotiza_products_item_value">
                <?php 
                    $prcunidad = $item->valor/$item->cantidad;
                    echo number_format($prcunidad,0,".",","); 
                ?>
            </div>
            <div class="cotiza_products_item_value">
                <?php echo number_format($prcmarca,0,".",","); ?>
            </div>
            <div class="cotiza_products_item_value">
                <?php echo number_format(((ceil($prcunidad) + ceil($prcmarca))*$item->cantidad),0,".",","); ?>
            </div>                
        </div>
        <?php } ?>
    </div>
</div>