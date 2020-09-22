<?php
defined('_JEXEC') or die;
// Get general Model.
require_once JPATH_COMPONENT_SITE. '/models/generals.php';
// Add Document Script.
$document = JFactory::getDocument();
$document->addScript(JURI::base().'/media/system/js/core.js');

// crete Script Event For Speed Users 
$scriptSpeed = ($this->userSpeed === true)?" ga('send', 'event', 'botones', 'suscr_frm_compl_expr', 'Registro complementario formulario express'); ":"";
// create Script Js
$scriptJS = "
    jQuery( document ).ready(function() {
    // Asigno calendario Fecha Primera Fuente.
    jQuery('#fco_fpfuente, #jform_profile_fechaProducto').datepicker({
        changeMonth: true,
        changeYear: true,
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dateFormat: 'dd-mm-yy',
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        yearRange: '-100:+0'        
    });    
	//Envío formulario.
        jQuery('#frm_cnfcotiza').on('submit', function(e) {
            e.preventDefault();
            // validate profesional Check.
            if ($('#jform_profile_profesional_1:checked').length == 0) {
                profesional = 1;
            } else if ($('#jform_profile_profesional_2:checked').length == 0) {
                profesional = 2;
            }
            jQuery.ajax({
                data:  {
                    fco_nota:        jQuery('#fco_nota').val(),
                    fco_name:        jQuery('#fco_name').val(),
                    fco_email:       jQuery('#fco_email').val(),
                    fco_tled:        jQuery('#fco_tled').val(),
                    fco_rlead:       jQuery('#fco_rlead').val(),
                    fco_pcanal:      jQuery('#fco_pcanal').val(),
                    fco_pfuente:     jQuery('#fco_pfuente').val(),
                    fco_fpfuente:    jQuery('#fco_fpfuente').val(),

                    fco_empresa:     jQuery('#fco_empresa').val(),
                    fco_ciudad:      jQuery('#fco_ciudad').val(),
                    fco_telefono:    jQuery('#fco_telefono').val(),

                    jfo_company:     jQuery('#jform_profile_company').val(),
                    jfo_sector:      jQuery('#jform_profile_sector').val(),
                    jfo_country:     jQuery('#jform_profile_country').val(),
                    jfo_profesional: profesional,
                    jfo_fecha:       jQuery('#jform_profile_fechaProducto').val(),
                    jfo_city:        jQuery('#jform_profile_city').val(),
                    jfo_phone2:      jQuery('#jform_profile_phone2').val(),
                    jfo_fax:         jQuery('#jform_profile_fax').val()
                },
                url:   '".JRoute::_('index.php?option=com_catpromocional&task=getqgenerated&cid=0&format=raw')."',
                type:  'post',
                dataType: 'html',
                beforeSend: function () {
                    $('#cont-finalizar-cotizacion').html('<div id=\"msj_gencotiza\">Generando cotización, favor espere un momento!</div>');
                },                
                success:  function (response) {
                    // evento Analytics - Registro Complementario.
                    ".$scriptSpeed."                    
                    // evento Analytics - Realiza Cotización.
                    ga('send', 'event', 'botones', 'cotiza', 'Realiza cotización');                    
                    //jQuery('#rspcotiza').html(response);
                    jQuery('#cont-carrito').hide();
                    sendQuotation(response);
                }
            });
        });
        // Create function send mail.
        function sendQuotation(response) {
            jQuery.ajax({
                data:  {
                    body: response,
                },
                url:   '".JRoute::_('index.php?option=com_catpromocional&task=sendMailQuotation&format=raw')."',
                type:  'post',
                dataType: 'html',
                success:  function (response) {
                    jQuery('#cont-finalizar-cotizacion').hide();
                    msg = { error: [response] };
                    Joomla.renderMessages(msg);
                    jQuery('html,body').animate({scrollTop: 0},'slow');
                }
            });
        }

        // Button remove cart.
        jQuery('.btn_rmvcart').on('click', function(e) {
            if (confirm('¿Está seguro que no desea cotizar el producto seleccionado?')) {
                var id = jQuery(this).attr('id');
                jQuery.ajax({ 
                    data:  {
                        id: id,
                        s: 2,
                    },
                    url: 'index.php?option=com_catpromocional&task=removeProductCart&format=raw',
                    type:  'post',
                    success:  function (response) {      
                        jQuery('.cont-tabla-'+id).hide();
                        jQuery('.producto-carrito-'+id).hide();
                    }
                });
            }
        });
    });";
// Add JS.
$document->addScriptDeclaration($scriptJS);
//d($this->lstproduct);
?>
<!----------------------------------------------------------------------------------- -->
<!------------------------------ FINALIZAR COTIZACIÓN. ------------------------------ -->
<!----------------------------------------------------------------------------------- -->
<form id="frm_cnfcotiza" method="post" action="<?php echo JRoute::_('index.php?option=com_catpromocional&task=getqgenerated'); ?>">
    <div id="cont-finalizar-cotizacion">
        <h2 id="productos-cotizados">Finalizar Cotizaci&oacute;n</h2>
        <div id="titulos-cantidad">
            <div class="cont-tabla-cotiza">
                <div class="titulo-nombre">Nombre</div>
            </div>
            <div class="cont-tabla-cotiza">
                <div class="titulo-nombre">Descripci&oacute;n</div>
            </div>
            <div class="cont-tabla-cotiza">
                <div class="titulo-referencia">Referencia</div>
            </div>
            <div class="cont-tabla-cotiza">
                <div class="titulo-tecnica">Cantidad Logos</div>
            </div>
            <div class="cont-tabla-cotiza">
                <div class="titulo-cantidad-producto">Cantidad Productos</div>
            </div>
            <div class="cont-tabla-cotiza">
                <div class="titulo-tecnica">Eliminar</div>
            </div>
        </div>
        <!--producto con cantidad 1-->
        <div class="cont-tabla-cotiza">
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla cont-tabla-<?php echo $key; ?>">
                    <?php echo CatpromocionalModelGenerals::getFormatString(ucfirst(strtolower($product['namproduct']))); ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-tabla-cotiza">
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla cont-tabla-<?php echo $key; ?>">
                    <?php echo CatpromocionalModelGenerals::getFormatString(ucfirst(strtolower($product['desproduct']))); ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-tabla-cotiza">
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla  cont-tabla-<?php echo $key; ?>">
                    <?php echo $product['refproduct']; ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-tabla-cotiza">
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla  cont-tabla-<?php echo $key; ?>">
                    <?php echo $product['cntlogos']; ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-tabla-cotiza">                    	
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla cont-tabla-<?php echo $key; ?>">
                    <?php echo $product['cntproduct']; ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-tabla-cotiza">
            <?php foreach($this->lstproduct as $key => $product) { ?>
                <div class="item-tabla cont-tabla-<?php echo $key; ?>">
                    <a id="<?php echo $key; ?>"  class="fa fa-trash btn_rmvcart" aria-hidden="true"></a>
                </div>
            <?Php } ?>
        </div>

        <p>Compruebe los datos y confirme la solicitud de cotizaci&oacute;n</p>
        <h3>Notas adicionales sobre la cotizaci&oacute;n:</h3>
        <textarea id="fco_nota" name="fco_nota" class="notas-cotizacion"></textarea>



        <?php /*************************************************************************************************/ 
		// valido si es un usuario Speed sin su información restante.
		if ($this->userSpeed === true) {
		?>        	
        <div class="men_registrese">
            Ya casi terminamos !!!
        </div>
        <div class="men_registrese_texto">
            Para darte un mejor servicio, favor envíanos la siguiente información:
        </div>

        <div id="contInfo" class="cls_frmregcotiza">
            <table class="table" >
                <tbody>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-building-o reg2"></i>Empresa*</div></td>
                        <td><input type="text" name="jform[profile][company]" id="jform_profile_company" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-cog reg2"></i>Sector</div></td>
                        <td>
                            <select name="jform[profile][sector]" id="jform_profile_sector" class="InfoUser" >
                                <option value="0">Seleccione Sector</option>
                                <?php
                                // Show Sectors.
                                foreach ($this->sectors as $sector) {
                                    echo "<option value='".$sector->id."'>".$sector->nombre."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-globe reg2"></i>País*</div></td>
                        <td>
                            <select name="jform[profile][country]" id="jform_profile_country" class="InfoUser" required >
                                <option value="0">Seleccione Pais</option>
                                <?php
                                // Show Countries.
                                foreach ($this->countries as $country) {
                                    echo "<option value='".$country->id."'>".$country->nombre."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="itemUser">
                                <i class="fa fa-user reg2"></i>¿Eres profesional independiente de publicidad y mercadeo?*
                            </div>
                        </td>
                        <td>
                           Si <input type="radio" name="jform[profile][profesional]" id="jform_profile_profesional_1" class="InfoUser" value="1" required>
                           No <input type="radio" name="jform[profile][profesional]" id="jform_profile_profesional_2" class="InfoUser" value="2" required> 
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="itemUser">
                                <i class="fa fa-calendar reg2"></i>Fecha aproximada en la que necesitarás tu producto*
                            </div>
                        </td>
                        <td>
                           <input type="text" name="jform[profile][fechaProducto]" id="jform_profile_fechaProducto" 
                           class="InfoUser" required>
                        </td>
                    </tr>

                    <tr>
                        <td><div class="itemUser"><i class="fa fa-location-arrow reg2"></i>Ciudad*</div></td>
                        <td><input type="text" name="jform[profile][city]" id="jform_profile_city" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-phone reg2"></i>Teléfono</div></td>
                        <td><input type="text" name="jform[profile][phone2]" id="jform_profile_phone2" class="InfoUser" ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-fax reg2"></i>Fax</div></td>
                        <td>
                            <input type="text" name="jform[profile][fax]" id="jform_profile_fax" class="InfoUser" >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
			}
			/*************************************************************************************************/ ?>
        <?php
        // Validate Executive User.
        //d($this->user->groups);exit;
        if (in_array(10, $this->user->groups)) {
        ?>
        <table class="table" >
            <tbody>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-user reg2"></i>Nombre Cliente*</div></td>
                    <td>
                        <input type="text" id="fco_name" name="fco_name" class="InfoUser" required>
                    </td>                      
                </tr>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-at reg2"></i>Email Cliente*</div></td>
                    <td>
                        <input type="email" id="fco_email" name="fco_email" class="InfoUser" required>
                    </td>                      
                </tr>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-building-o reg2"></i>Empresa*</div></td>
                    <td>
                        <input type="text" id="fco_empresa" name="fco_empresa" 
                        class="InfoUser" required />
                    </td>                      
                </tr>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-sun-o reg2"></i>Ciudad*</div></td>
                    <td>
                        <select id="fco_ciudad" name="fco_ciudad" required class="InfoUser">
                            <option value="">Seleccione ciudad</option>
                            <?php foreach($this->lstcities as $ciudad) { ?>
                                <option value="<?php echo $ciudad->id; ?>">
                                    <?php echo $ciudad->nombre; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td> 
                </tr>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-phone reg2"></i>Teléfono*</div></td>
                    <td>
                        <input type="text" id="fco_telefono" name="fco_telefono" 
                        class="InfoUser" required />
                    </td>                      
                </tr>
                <tr>
                    <td><div class="itemUser"><i class="fa fa-sort-amount-asc reg2"></i>Canal*</div></td>
                    <td>
                        <select name="fco_pcanal" id="fco_pcanal" class="InfoUser" required>
                            <option value="">Canal</option>
                            <?php
                            foreach ($this->lcanal as $sfirst) {
                                echo "<option value='".$sfirst['id']."'>".$sfirst['nombre']."</option>";
                            }
                            ?>
                        </select>
                    </td>                      
                </tr>
            </tbody>
        </table>
        <?php 
        } 
        //<h2 id="confirmar-cotizaccion">Confirmar cotizaci&oacute;n</h2>
        ?>
        <input type="submit" id="confirmar-cotizaccion" 
            value="Enviar cotizaci&oacute;n al correo: <?php echo $this->user->email; ?>" >
    </div>
</form>
<!-- Div respuesta Cotización -->
<div id="rspcotiza"></div>