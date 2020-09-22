<?php
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$scriptJS = "
jQuery( document ).ready(function() {
    //codigo del formulario de registro según check.
    jQuery('#fic_chkuser1, #fic_chkuser2').on('click', function() {
        if (jQuery(this).val() == 1) {
            jQuery('.cls_frmregcotiza').hide();
        } else {
            jQuery('.cls_frmregcotiza').show();
        }
    });
    // Oculto por defecto.
    jQuery('#fic_chkuser1').trigger('click');
    // Member registration.
    jQuery('#member-registration').on('submit', function() {
        ga('send', 'event', 'BotonRegistro', 'HaceClic');
    });    
});";
// Add JS.
$document->addScriptDeclaration($scriptJS);
?>
<!-- -------------------------------------------------------------------------------- --->
<!-- ----------------------------- FINALIZAR COTIZACIÓN. ---------------------------- --->
<!-- -------------------------------------------------------------------------------- --->
<div id="cont-finalizar-cotizacion">
    <h2 id="productos-cotizados">Finalizar Cotización</h2>
    <div class="req-campo-registro">
        <input type="radio" id="fic_chkuser1" name="fic_chkuser" value="1" checked="checked">
        <label>
            Si ya es cliente, introduzca su correo y contrase&ntilde;a, en el m&oacute;dulo de 
            login que se encuentra en la izquierda
        </label>
    </div>
    <div class="req-campo-registro">
        <input type="radio" id="fic_chkuser2" name="fic_chkuser" value="2">
        <label>¿No es cliente? marque esta opci&oacute;n, cree su cuenta y reciba su cotizaci&oacute;n!</label>
    </div>
    <!-- --------------------------------------------------------------------------------- -->
    <!-- ----------------------------- INFORMACIÓN CLIENTE. ----------------------------- --->
    <!-- -------------------------------------------------------------------------------- --->        
    <h2 id="informacion" class="cls_frmregcotiza"> INFORMACIÓN DEL CLIENTE</h2>
    <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
        <div id="contInfo" class="cls_frmregcotiza">
            <table class="table" >
                <tbody>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-at reg2"></i>Email*</div></td>
                        <td><input type="email" name="jform[email1]" id="jform_email1" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-at reg2"></i>Confirmar Email*</div></td>
                        <td>
                            <input type="email" name="jform[email2]" id="jform_email2" class="InfoUser" required >
                            <input type="hidden" name="jform[username]" id="jform_username" value="<?php echo strtotime(date("Ymd His")); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-lock reg2"></i>Contrase&ntilde;a*</div></td>
                        <td><input type="password" name="jform[password1]" id="jform_password1" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-lock reg2"></i>Confirmar Contrase&ntilde;a*</div></td>
                        <td><input type="password" name="jform[password2]" id="jform_password2" class="InfoUser" required ></td>
                    </tr>
                </tbody>
            </table>
            <!------------------------------------------------------------------------------------->
            <!--------------------------- DATOS PERSONALES DEL CLIENTE. --------------------------->
            <!------------------------------------------------------------------------------------->
            <h2 id="datos" class="cls_frmregcotiza">DATOS PERSONALES DEL CLIENTE</h2>
            <table class="table cls_frmregcotiza" >
                <tbody>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-user reg2"></i>Nombre*</div></td>
                        <td><input type="text" name="jform[name]" id="jform_name" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-building-o reg2"></i>Empresa*</div></td>
                        <td><input type="text" name="jform[profile][company]" id="jform_profile_company" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-cog reg2"></i>Sector</div></td>
                        <td>
                            <select name="jform[profile][sector]" id="jform_profile_sector" class="InfoUser">
                                <option value="">Seleccione Sector</option>
                                <?php
                                foreach($this->sectors as $sector) {
                                    echo "<option value='".$sector->id."'>".$sector->nombre."</option>";
                                }    
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-globe reg2"></i>País*</div></td>
                        <td>
                            <select name="jform[profile][country]" id="jform_profile_country" class="InfoUser">
                                <option value="">Seleccione Pais</option>
                                <?php
                                foreach($this->countries as $country) {
                                    echo "<option value='".$country->id."'>".$country->nombre."</option>";
                                }    
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-location-arrow reg2"></i>Ciudad*</div></td>
                        <td><input type="text" name="jform[profile][city]" id="jform_profile_city" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-phone reg2"></i>Teléfono</div></td>
                        <td><input type="text" name="jform[profile][phone]" id="jform_profile_phone" class="InfoUser" ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-mobile reg2"></i>Teléfono Móvil*</div></td>
                        <td><input type="text" name="jform[profile][phone2]" id="jform_profile_phone2" class="InfoUser" required ></td>
                    </tr>
                    <tr>
                        <td><div class="itemUser"><i class="fa fa-fax reg2"></i>Fax</div></td>
                        <td>
                            <input type="text" name="jform[profile][fax]" id="jform_profile_fax" class="InfoUser" >
                            <?php
                            /*****************************************************************************
                            // Get Input.
                            $input = JFactory::getApplication()->input;
                            ?>
                            <input type="hidden" name="jform[profile][source]"  id="jform_profile_source" value="<?php echo $input->getString('utm_source',''); ?>" >
                            <input type="hidden" name="jform[profile][medium]"  id="jform_profile_medium" value="<?php echo $input->getString('utm_medium',''); ?>" >
                            <input type="hidden" name="jform[profile][term]"    id="jform_profile_term" value="<?php echo $input->getString('utm_term',''); ?>" >
                            <input type="hidden" name="jform[profile][content]" id="jform_profile_content" value="<?php echo $input->getString('utm_content',''); ?>" >
                            <input type="hidden" name="jform[profile][campaign]" id="jform_profile_campaign" value="<?php echo $input->getString('utm_campaign',''); ?>" >                        
                            <?php
                            /******************************************************************************/
                            echo JHtml::_('form.token');
                            ?>
                            <input type="hidden" name="option" value="com_users" />
                            <input type="hidden" name="task" value="registration.register" />                            
                        </td>
                    </tr>
                    <tr>
                        <td id="tdregistrar" colspan="2">
                            <input id="registrar" type="submit" value="REGISTRARSE">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>