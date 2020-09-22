<?php
defined('_JEXEC') or die;
// Get general Model.
require_once JPATH_COMPONENT_SITE. '/models/generals.php';
// Get Document.
$document = JFactory::getDocument();
$document->addScript(JURI::base().'/media/system/js/core.js');
$document->setBase("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
$scriptJS = "
    jQuery( document ).ready(function() {
        // function updateCart.
        jQuery.fn.updateCart = function() {
            jQuery.ajax({
                data:  {},
                url:   'index.php?option=com_catpromocional&task=getUpdateCartAjax&format=raw',
                type:  'post',
                success:  function (response) {
                    jQuery('#cont-carrito').html(response);
                }
            });            
        };
        // function validateQuantities.
        jQuery.fn.validateQuantities = function() {
            var cntl = parseInt(jQuery('#prd_canlogos').val()) || 0;
            var cntp = parseInt(jQuery('#prd_canproductos').val()) || 0;
            var msg = {};
            if (cntl == 0) {
                msg = { error: ['No seleccionó la cantidad de logos con los que se marcará el producto'] };
                Joomla.renderMessages(msg);
                return false;
            } else if (cntp == 0) {
                msg = { error: ['No seleccionó la cantidad de productos que desea cotizar'] };
                Joomla.renderMessages(msg);
                return false;
            }
            return true;
        };
        // function validateInfo.
        jQuery.fn.validateInfo = function() {
            var cnt = parseInt(jQuery('#prd_canlogos').val());
            var msg = {};
            for (l=1; l <= cnt; l++) {
                if (jQuery('#prd_tecnica_'+l).val() == ''
                || jQuery('#prd_unidad_'+l).val() == '') {
                    msg = { error: ['El logo '+l+', no cuenta con información de técnica y unidad'] };
                    Joomla.renderMessages(msg);
                    return false;    
                }                
            }
            return true;
        };
        // function validateCantity.
        jQuery.fn.validateCantity = function() {
            var cnt = parseInt(jQuery('#prd_canproductos').val());
            if (cnt < ".$this->infproduct->cnt_minima.") {
                msg = { error: ['Se pueden cotizar mínimo ".$this->infproduct->cnt_minima." unidades del producto actual'] };
                Joomla.renderMessages(msg);
                return false;
            }
            return true;
        };
        // envio formulario exc.
        jQuery('#btn_adjprcproduct').on('click', function(e) {
                e.preventDefault();   
                jQuery('#frm_prd_prcscale').submit();
        });  
    	// codigo del popup de ayuda
    	jQuery('#boton-ayuda').on('click', function() {
                jQuery('#popup-ayuda').show();
                jQuery('#boton-ayuda').hide();
    	});	
    	jQuery('#boton-cerrar').on('click', function() {
    		jQuery('#popup-ayuda').hide();
    		jQuery('#boton-ayuda').show();
    	})    
            // Reinicio Informacion Formulario
    	jQuery('#brrInformacion').on('click', function() {
                jQuery('#prd_canlogos').val(0);
                jQuery('#prd_canlogos').trigger('change');
                jQuery('#prd_canproductos').val(0);
    	});        
    	jQuery('#prd_canlogos').on('change', function() {
                var cantidad = jQuery(this).val();
                jQuery.ajax({
                    data:  {
                        cantidad: cantidad,
                        productid: ".$this->idproduct."
                    },
                    url:   'index.php?option=com_catpromocional&task=gettechniquesbyLogoAndProduct&format=raw',
                    type:  'post',
                    success:  function (response) {
                        jQuery('#tbdinamica').html('');
                        jQuery('#tbdinamica').append(response);
                    }
                });
    	});
        // get Units
        jQuery(document.body).on('change', '.prdtecnicas' ,function() {
            var id = jQuery(this).val();
            var tecsplit = jQuery(this).attr('id').split('_');
            jQuery.ajax({
                data:  {
                    id: id,
                    field: tecsplit[2],
                },
                url: 'index.php?option=com_catpromocional&task=getunitsbyTechnique&format=raw',
                type:  'post',
                success:  function (response) {
                    jQuery('#prd_unidad_'+tecsplit[2]).empty().append(response);
                }
            });
        });

        // Button remove cart.
        jQuery(document.body).on('click', '.btn_rmvcart' ,function() {
            if (confirm('¿Está seguro que no desea cotizar el producto seleccionado?')) {
                var id = jQuery(this).attr('id');
                jQuery.ajax({ 
                    data:  {
                        id: id,
                        s: 1,
                    },
                    url: 'index.php?option=com_catpromocional&task=removeProductCart&format=raw',
                    type:  'post',
                    success:  function (response) {      
                        jQuery('.cont-tabla-'+id).hide();
                        jQuery.fn.updateCart();
                    }
                });
            }
        });
        /////////////////////////////////////////////////////////////////////////////
        // Tooltips.
        $('body').tooltip({
            selector: '#ttp_technique',
            content: function() {
                if ($(this).attr('id') == 'ttp_technique') {
                    return $('.cnt_ttp_technique').html();
                } else if ($(this).attr('id') == 'ttp_unidad') {
                    return $('.cnt_ttp_unit').html();
                } else if ($(this).attr('id') == 'ttp_quantity') {
                    return $('.cnt_ttp_quantity').html();
                } 
            }
        });
        /////////////////////////////////////////////////////////////////////////////
        // Send Form.        
    	$('#anaCotizacion').on('click', function(e) {
                // Validate select values.
                //if (jQuery.fn.validateQuantities() === true) {
                    if (jQuery.fn.validateInfo() === true) {
                        if (jQuery.fn.validateCantity() === true) {
                            var formData = $('#frm_addcotizacion').serialize();
                            console.log(formData);
                            $.ajax({
                                data:  {
                                    productid: ".$this->idproduct.",
                                    form: formData
                                },
                                url:   'index.php?option=com_catpromocional&task=addProductQuotation&format=raw',
                                type:  'post',
                                success:  function (response) {
                                    $('#cont-cotizacion').html(response);
                                    jQuery.fn.updateCart();                                    
                                },
                                error: function(error,x,y) {
                                    alert(error+' - '+x+' - '+y);
                                }
                            });
                        }
                    }
                //}
    	});
        // Get Images Galery.
        var evt = new Event(),
        m = new Magnifier(evt, {
            zoom: 3,
            zoomable: true,
            largeWrapper: document.getElementById('gallery-preview')
        }),
        imageData = [
";
// Validate Product Has Images.
if (count($this->imgproduct) > 0) {
    // Loop images Gallery.
    foreach ($this->imgproduct as $imagen) {
        // Validate Image exist.
        if (@JFile::exists(JPATH_BASE."/images/catalog/products/slider/".end(@explode('/',$imagen->path)))) {
            @$image = JURI::root()."images/catalog/products/slider/".end(@explode('/',$imagen->path));
        } else {
            //$image = JURI::root()."images/catalog/default_image_slider.jpg";
            $image = JURI::root()."images/catalog/products/slider/".end(@explode('/',$imagen->path));
        }
        // Generate Script.
        $scriptJS .= "
                {
                    title: '".trim($this->infproduct->nombre)."',                
                    thumb: '".$image."',
                    large: '".JURI::root().$imagen->path."',
                    largeWrapper: 'preview',
                    id: 'http://www.google.com.co'
                },
        ";
    }
} else {
    // Generate Script.
    $scriptJS .= "
        {
            title: '".trim($this->infproduct->nombre)."',                
            thumb: '".JURI::root()."images/catalog/default_image_slider.jpg',
            large: '".JURI::root()."images/catalog/default_image_slider.jpg',
            largeWrapper: 'preview',
            id: 'http://www.google.com.co'
        },
    ";
}
$scriptJS .= "
        ],
        gallery = new Gallery(evt, m, {
            gallery: document.getElementById('gallery'),
            images: imageData,
            prev: document.getElementById('gallery-prev'),
            next: document.getElementById('gallery-next'),
            previewText: document.getElementById('gallery-preview-title')
        });
        // Set URL.
        jQuery('ul#gallery > li > a').attr('href', window.location.href);
    });";
// Add JS.
$document->addScriptDeclaration($scriptJS);
?>
<!----------------------------------------------------------------------------->
<!-------------------------------- DIV GALLERY -------------------------------->
<!----------------------------------------------------------------------------->
<!--producto y cotizador-->
<div class="title" id="gallery-preview-title" style="display: none">&nbsp;</div>
<div class="gallery">
    <!--imagen o slider de los productos-->
    <div class="slider">
        <ul id="gallery"></ul>
    </div>
    <!--cotizador y zoom de la imagen-->
    <div class="magnifier-preview" id="gallery-preview">
        <form id="frm_addcotizacion" method="post">
            <table id="tablaCotizador" cellspacing="2" align="center">
                <tr>
                    <td id="tituloTablaCotizador" colspan="3" >
                    <?php 
                        echo CatpromocionalModelGenerals::getFormatString($this->infproduct->nombre); ?>                        
                    </td>
                    <td id="boton-ayuda"><i class="fa fa-question-circle ayuda-cotizador"></i></td>
                </tr>
                <tr>
                    <td>¿Con cu&aacute;ntos logos va a marcar el producto?</td>
                    <td>
                        <select name="prd_canlogos" id="prd_canlogos" style="width:100px; margin-left:10px;" >
                            <option value="0">Sin Logos</option>
                            <?php
                            for ($c=1;$c<=7;$c++) {
                                echo "<option value='".$c."'>".$c."</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table id="tbdinamica" cellspacing="2">
                            <tr>
                                <td colspan="3" align="center" style="padding-bottom:10px;">
                                    ¿Con qu&eacute; t&eacute;cnica de marcación desea sus logos?
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>¿Cu&aacute;ntas unidades de producto quiere cotizar?</td>
                    <td>
                        <a id="ttp_quantity" class="fa fa-info-circle lnk_tooltip" 
                        aria-hidden="true" title=""></a>
                        <span class="cnt_ttp_quantity">
                            <div class="ttp_quantity">Indica la cantidad de productos que deseas cotizar y luego, oprime el botón “añadir cantidad”. Si necesitas cotizar una cantidad diferente simplemente debes cambiar la cantidad y oprimir nuevamente: añadir cantidad
                            </div>
                        </span>
                        <input type="number" name="prd_canproductos" id="prd_canproductos" size="10" min="1" value="1">
                    </td>
                </tr>
                <tr style="background-color:rgb(245, 245, 245) ">
                    <td colspan="3" align="center">
                        <input type="button" id="brrInformacion" value="Borrar Informaci&oacute;n">
                        <input type="button" id="anaCotizacion" value="A&ntilde;adir Cantidad">
                    </td>
                </tr>			
            </table>
        </form>
    </div>  
    <!--botones pasar imagen-->
    <div class="btn-wrapper">
        <button class="prev" id="gallery-prev">&lt;</button>
        <button class="next" id="gallery-next">&gt;</button>
    </div>
    <!--inicio del pop up-->               
    <div id="popup-ayuda">
        <div id="boton-cerrar">X</div>   
        <div id="contenido-ayuda">
            <h1 class="titulo-ayuda">Informaci&oacute;n de Ayuda</h1>
            <p class="texto-ayuda">
                El cotizador se usa de la siguiente manera...
            </p>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------>   
<!--tabla de cotizacion del producto-->
<!------------------------------------------------------------------------------>   
<div id="cont-cotizacion">
</div>
<!------------------------------------------------------------------------------>        
<!--estado y precios para ejecutivos -->
<!------------------------------------------------------------------------------>
<?php
// Validate Executive User.
if (in_array(10, $this->user->groups)) {
?>
    <div id="cont_executive">
        <h2>ADMINISTRACI&Oacute;N PRODUCTOS: PARA EJECUTIVO <span>Proveedor: <?php echo $this->infproduct->proveedor; ?></span></h2>
        <div class="cont_exeestado">
            <div class="cont_exetitle">
                Estado producto
            </div>
            <div class="cont_exebutton">
                <?php
                $est = ($this->infproduct->publicado == 2)?1:2;
                ?>
                <a href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=disableProduct&id='.
                    $this->infproduct->id.'&view=executives&v=2&est='.$est) ?>">
                    <?php echo $this->infproduct->publicado == 2 ? "Mostrar":"Ocultar"; ?>
                </a>
            </div>
        </div>
        <div class="cont_exeprecios">
            <div class="cont_exetitle">
                Precios producto
                <a href="#" id="btn_adjprcproduct">Ajustar</a>
            </div>        
            <form id="frm_prd_prcscale" method="post" action="<?php echo JRoute::_('index.php?option=com_catpromocional&task=changePricesProduct&view=executives') ?>">
            <?php
            foreach ($this->ranScale as $ranScale) { 
            ?>
                <input type="hidden" name="id" value="<?php echo $this->infproduct->id; ?>" >
                <div class="cont_exeprices">
                    <div class="cont_exeprice">
                        <div class="cont_exepricelabel">
                        <?php echo $ranScale->rango_inicial." - ".$ranScale->rango_final; ?>
                        </div>
                        <div class="cont_exepriceinput">
                            <input type="text" name="price_range[<?php echo $ranScale->id; ?>]" 
                                value="<?php echo number_format($ranScale->valor,0,',','.'); ?>" >
                        </div>
                    </div>
                </div>
            <?php } ?>
            </form>
        </div>
    </div>
<?php
}
?>
<div id="nombre-producto"><h1><?php echo "Características del producto: ".
    CatpromocionalModelGenerals::getFormatString($this->infproduct->nombre); ?></h1></div>
<!------------------------------------------------------------------------------>        
<!--descripcion, especificaciones, opciones-->
<!------------------------------------------------------------------------------>
<div id="tabs">
    <ul id="tabsID">
      <li><a class="tituloTab" href="#tabs-1">DESCRIPCI&Oacute;N</a></li>
      <li><a class="tituloTab" href="#tabs-2">ESPECIFICACIONES</a></li>
    </ul>
    <div id="tabs-1">
      <p><?php echo CatpromocionalModelGenerals::getFormatString($this->infproduct->descripcion); ?>  
    </div>
    <div id="tabs-2">
      <p><?php echo CatpromocionalModelGenerals::getFormatString($this->infproduct->especificaciones); ?></p>
    </div>            
</div>