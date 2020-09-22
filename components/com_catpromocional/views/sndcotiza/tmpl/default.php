<!--<div id="msj_sndcotiza">-->
    <?php 
    if ($this->message != "") { 
        echo strip_tags($this->message);
    } else {
    ?>
    La cotizaci&oacute;n ha sido enviada al correo electr&oacute;nico <span><?php echo $this->usr_email; ?></span>.
    Para cualquier duda o información adicional, favor comuniquese a nuestro PBX 702 9909 o al correo: <span>mercadeo@prpromocionales.com </span>
    <?php } ?>
<!--</div>-->
