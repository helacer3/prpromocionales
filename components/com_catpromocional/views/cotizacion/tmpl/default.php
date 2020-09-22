<?php
defined('_JEXEC') or die;
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    </head>
    <body>
        <table style="width:800px; max-width: 100%;" cellpadding="0" cellspacing="0" border="0">
            <!-- Fila Logo -->
            <tr>
                <td style="text-align:center">
                    <img src="<?php echo JURI::base(); ?>images/logo.png" alt="ProyectaT" />
                </td>
            </tr>
            <!-- Fila Intro -->
            <tr class="fil_intro">
                <td style="border-top: 1px solid #E87817;border-bottom: 1px solid #E87817;font-size: 11px; padding: 11px 5px;">
                    <?php if (property_exists($this->qtext, 'introduccion')) echo $this->qtext->introduccion; ?></p>
                </td>
            </tr>
            <!-- Fila Datos Cotizacion -->
            <tr>
                <td>
                    <table style="width:100%; max-width: 100%;" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td colspan="2" style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                                COTIZACI&Oacute;N
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Número de Cotización
                            </td>
                            <td style="width: 50%">
                                <?php echo $this->quotation->id; ?>
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Fecha
                            </td>
                            <td style="width: 50%">
                                <?php echo $this->strdate; ?>
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Cotizaciones realizadas desde 14/10/2014
                            </td>
                            <td style="width: 50%">
                                <?php echo $this->cntquotation; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                                INFORMACI&Oacute;N DEL CLIENTE
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                E-mail
                            </td>
                            <td style="width: 50%">
                                <?php echo $this->user->email; ?>
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Nombre Completo
                            </td>
                            <td style="width: 50%">
                                <?php echo $this->user->name; ?>
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Empresa
                            </td>
                            <td style="width: 50%">
                                
                                    <?php 
                                    if (array_key_exists('company', $this->userprofile->profile))  {
                                        if ($this->userprofile->profile['company'] != "")
                                            echo $this->userprofile->profile['company'];
                                        else 
                                            echo "-"; 
                                    }
                                    ?>
                                
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Ciudad
                            </td>
                            <td style="width: 50%">
                                
                                    <?php 
                                    if (array_key_exists('city', $this->userprofile->profile)) {
                                        if ($this->userprofile->profile['city'] != "")
                                            echo $this->userprofile->profile['city'];
                                        else 
                                            echo "-"; 
                                    }
                                    ?>
                                            
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                País
                            </td>
                            <td style="width: 50%">
                                
                                    <?php echo $this->couname; ?>
                                            
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Teléfono
                            </td>
                            <td style="width: 50%">
                                
                                    <?php 
                                    if (array_key_exists('phone', $this->userprofile->profile)) {
                                        if ($this->userprofile->profile['phone'] != "")
                                            echo $this->userprofile->profile['phone'];
                                        else 
                                            echo "-"; 
                                    }
                                    ?>
                                           
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Teléfono Movil
                            </td>
                            <td style="width: 50%">
                                
                                    <?php 
                                    if (array_key_exists('phone2', $this->userprofile->profile)) {
                                        if ($this->userprofile->profile['phone2'] != "")
                                            echo $this->userprofile->profile['phone2'];
                                        else 
                                            echo "-"; 
                                    }
                                    ?>
                                       
                            </td>
                        </tr>
                        <tr style="font-size: 12px;">
                            <td style="width: 50%; font-weight: bold; padding:5px 2px;">
                                Fax
                            </td>
                            <td style="width: 50%">
                                
                                    <?php 
                                    if (array_key_exists('fax', $this->userprofile->profile)) {
                                        if ($this->userprofile->profile['fax'] != "")
                                            echo $this->userprofile->profile['fax'];
                                        else 
                                            echo "-"; 
                                    }
                                    ?>
                                    
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Fila Cotizacion -->
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="1" border="0" style="width: 800px; max-width: 100%">
                        <tr class="trlproducto" style="font-size:9px; text-align: center;">
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 5%;">Cnt.
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 14%;">Imagen
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 15%;">Nombre
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 25%;">Descripci&oacute;n
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 7%;">REF
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 10%;">Marcaci&oacute;n
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 7%;">Precio
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 7%;">Precio con Marcaci&oacute;n
                            </td>
                            <td style="background-color: #E87817; color: #FFF; font-size: 12px; padding: 5px 10px; width: 10%;">Subtotal
                            </td>
                        </tr>
                <?php
                if (count($this->itemquotation) > 0) {
                    foreach ($this->itemquotation as $item) {                        
                        //JRoute::_('index.php?option=com_catpromocional&task=getProduct&id='
                        // Codigo google Analytics para imagen.
                        $anaImagen = "?utm_source=Cotizaci%C3%B3n&utm_medium=Clic_Imagen&utm_campaign=Cotizaciones";
                        // Codigo google Analytics para referencia. 
                        $anaReferencia = "?utm_source=Cotizaci%C3%B3n&utm_medium=Clic_Referencia&utm_campaign=Cotizaciones";
                        // Set Vars.
                        $prcmarca = 0;
                        $prclogo = 0;
                        // Get Image Product.
                        $imgproduct = $this->modelp->getProductSingleInfo($item->id_producto);
                        // Set Price One Product.
                        $prcproduct = ceil($item->valor / $item->cantidad);
                        // Get Info Logos Item
                        $logproduct = $this->modelcq->getQuotationItemLogos($item->id);
                        // Set Imagen product.
                        $path = JPATH_BASE."/images/catalog/products/slider/".end(@explode('/',$imgproduct['path']));
                        // validate Image Exist
                        if (file_exists($path)) {
                            $imagen = JURI::root()."images/catalog/products/slider/". end(@explode('/',$imgproduct['path'])); 
                        } else {
                            $imagen = JURI::root()."images/catalog/default_image.jpg";             
                        }
                ?>
                        <tr class="trvproducto" style="font-size: 12px;">
                            <td style="border: 1px solid #E87817;">
                                <?php echo number_format($item->cantidad,0,',','.'); ?>
                            </td>
                            <td style="border: 1px solid #E87817; text-align: center;">
                                <?php
                                // get Image Size.
                                list($width, $height, $type, $attr) = getimagesize($imagen);
                                //validate Size Image.
                                if (($width * 2) <=  $height) {
                                    $imgWidth  = "50%";
                                    $imgHeight = "15";
                                }
                                else{
                                    $imgWidth = "100%";
                                    $imgHeight = "auto";
                                }
                                ?>
                                <a href="<?php 
                                    echo JURI::base().'component/catpromocional/getproduct/'.
                                    (int)$item->id_producto.$anaImagen;
                                ?>" target="_blank" style="background-color: #FFF;">
                                    <img width="185" height: "<?php echo $imgHeight; ?>" 
                                    src="<?php echo $imagen; ?>" style="border:none; display:inline-block; 
                                    width: <?php echo $imgWidth; ?>; max-width:185px; max-height:185px;" />
                                </a>
                            </td>
                            <td style="border: 1px solid #E87817;">
                                <?php echo $item->nombre; ?>
                            </td>
                            <td style="border: 1px solid #E87817; padding: 5px; font-size: 11px;">
                                <?php
                                    echo $item->descripcion.' '.$item->especificaciones;
                                ?>
                            </td>
                            <td style="border: 1px solid #E87817;">                            
                                <a href="<?php 
                                    echo JURI::base().'component/catpromocional/getproduct/'.
                                    (int)$item->id_producto.$anaReferencia; ?>" target="_blank">
                                    <?php echo $item->referencia; ?>
                                </a>   
                            </td>
                            <td style="border: 1px solid #E87817;">
                                <?php
                                // Loop Logos
                                if (count($logproduct) > 0) {
                                    foreach ($logproduct as $logo) {
                                        // Precio marcacion.
                                        $prclogo = $this->modelcq->getPriceMrcLogo($logo,$item);
                                        // Precio Marcación.
                                        $prcmarca += $prclogo;
                                        echo "<div  style='padding: 2px; font-size: 10px; background-color: #F1F1F5;'>";
                                        echo "<b>$ ".number_format($prclogo, 0, ",", ".") . "</b><br />" . $logo->tecnica . 
                                        "<br />" .$logo->unidad . "<br />";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </td>
                            <td style="border: 1px solid #E87817;">
                                $ <?php echo number_format($prcproduct, 0, ",", "."); ?>
                            </td>
                            <td style="border: 1px solid #E87817;">
                                $ <?php echo number_format($prcmarca+$prcproduct, 0, ",", "."); ?>
                            </td>
                            <td style="border: 1px solid #E87817;">
                                $ <?php echo number_format(((ceil($prcmarca) + ceil($prcproduct)) * $item->cantidad), 0, ",", "."); ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
                    </table>
                </td>
            </tr>
            <!-- Términos de Negociación -->
            <tr>
                <td style="color: #E87817; padding-top:11px; font-size: 14px;">
                    T&eacute;rminos de Negociaci&oacute;n
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 10px;">
                    <?php if (property_exists($this->qtext, 'terminos')) echo $this->qtext->terminos; ?>
                </td>
            </tr>
            <!-- Datos Adicionales cotización -->
            <tr>
                <td  style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    NOTAS DEL CLIENTE
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->comentario; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    NOMBRE CLIENTE
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_cliente; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    EMAIL CLIENTE
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->email_cliente; ?>
                </td>
            </tr>
            <tr>
                <td  style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    EMPRESA
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->empresa; ?>
                </td>
            </tr>
            <tr>
                <td  style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    CIUDAD
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->ciudad; ?>
                </td>
            </tr>
            <tr>
                <td  style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    TEL&Eacute;FONO
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->telefono; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; color: #FFF; background-color: #7C7B7B; width: 100%;">
                    CANAL
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 7px;">
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_canal; ?>
                </td>
            </tr>
            <!-- Pie de página Correo -->
            <tr>
                <td style="border-top: 1px solid #E87817; border-bottom: 1px solid #E87817; font-size:11px; padding: 11px 0;">
                    <?php if (property_exists($this->qtext, 'footer')) echo $this->qtext->footer; ?>
                </td>
            </tr>
        </table>
    </body>
</html>