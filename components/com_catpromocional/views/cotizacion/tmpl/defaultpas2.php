<?php
defined('_JEXEC') or die;
error_reporting(0);
//$document = JFactory::getDocument();
// Add styles
echo $style = '
<STYLE type="text/css">

#header{
    width: 100%;
    height: auto;
    text-align:center;
}
p{
    font-family: sans-serif;
    font-size: 0.9em;
    font-weight: lighter;
    color:#000;
    padding: 0;
    text-align: -webkit-left;
    margin: 1%;
    width: auto;
}

h1{
    font-family: sans-serif;
    font-size: 1em;
    font-weight: 400;
    color: #E87817;
    padding: 0;
    text-align: -webkit-left;
    width: auto;
}

h2{
    font-family: sans-serif;
    font-size: 0.8em;
    font-weight: lighter;
    color:#000;
    padding: 0;
    text-align: -webkit-left;
    width: auto;
    margin: 2% 4%;
}

h3{
    font-family: sans-serif;
    font-size: 0.9em;
    font-weight: lighter;
    color:#fff;
    padding: 0;
    text-align: -webkit-left;
    width: auto;
    text-transform: uppercase;
}
i{
     margin: 0 1%; 
}
li{
    font-family: sans-serif;
    font-size: 0.7em;
    font-weight: lighter;
    color:#000;
    padding: 0 2%;
    text-align: -webkit-left;
    width: auto;
    list-style: circle;
}
table.principal {
    width: 100%;
    margin: 25px 0 20px 0;
}
table.interna {
    width: 100%;
    margin: 0;
}

table.interna td.normal, table.interna th.normal,
table.interna td.small, table.interna th.small {
    border: 1px solid rgb(232, 120, 23);    
    font-family: sans-serif;
    font-weight: lighter;
    text-align: -webkit-center;
    padding: 0.5%;
    font-size: 0.8em;
}
table.interna td.normal, table.interna th.normal {
    width: 12% !important;
    text-align: left;
    //text-justify: inter-word;
}
table.internab td.small, table.internab th.small {
    width: 9% !important;
}
table.interna th.small,
table.interna th.normal {
    font-size: 0.9em;    
}
table.interna th {
    background-color: rgb(232, 120, 23);
    color: #fff;
    font-family: sans-serif;
    font-weight: lighter;
    font-size: 1em;
    padding: 0.5%;
}
table.interna td {
    font-size: 0.8em;
}
td > a {
    margin: 0 auto;
    width:99%;
    padding: 0 !important;
    text-decoration: none;
    text-align:center;
}
.div_marcacion {
    width: 98%;
    float: left;
    position: relative;
    display: inline-block;
    font-size: 9px;
    margin-bottom:5px;
    background-color: #EFEFEF;
}
#description{
    width: 100%;
    border-top: 1px solid #E87817;
    border-bottom: 1px solid #E87817;  
    padding: 5px; 
}

.box-title{
    background: #7C7B7B;
    width: 100%;
    padding: 3px 7px;
    height: auto;
}
.box-title-executive{
    background: #7C7B7B;
    width: 100%;
    padding: 3px 7px;
    height: 20px;
}

.tablecell {
    width: 48%;
    background-color: rgb(239, 239, 239);
    padding: 5px;
    text-align:left;
}


#personalData{
    width: 100%;
    height: auto;
    position: relative;
    float: left;
}
#tableArticle{
    width: 100%;
    height: auto;
    position: relative;
    float: left;
    margin: 0 1% 0 0;
    padding: 0;
}
#termsTrade{
    width: 100%;
    height: auto;
    position: relative;
    float: left;
    margin: 2% 0;
    padding: 0;   
}
#terms{
    width: 100%;    
    height: auto;
    position: relative;
    float: left;
    margin: 0;
    padding: 0;
}
#notes_executive{
    width: 100%;    
    height: auto;
    padding: 0 5px;
}
#greeting{
    width: 100%;
    height: auto;
    border-top: 1px solid #E87817;
    border-bottom: 1px solid #E87817;
    padding: 5px;
}
#tdterminos {
    padding: 5px 10px;
    font-weight: bold;
}
</style>';
//$document->addStyleDeclaration($style);
?>
<table class="principal">
    <tr>
        <td colspan="2" id="header">
            <img src="<?php echo JURI::base(); ?>images/logo.png" />
        </td>
    </tr>
    <tr>
        <td colspan="2" id="description">
            <p><?php if (property_exists($this->qtext, 'introduccion')) echo $this->qtext->introduccion; ?></p>
        </td>
    </tr>    
    <tr>
        <td colspan="2" class="box-title">
            <h3><i class="fa fa-list"></i>Cotización</h3>
        </td>
    </tr>
    <tr>
        <td class="tablecell"><h2>Numero de Cotizaci&oacute;n:</h2></td>
        <td class="tablecell"><h2><?php echo $this->quotation->id; ?></h2></td>
    </tr>
    <tr>        
        <td class="tablecell"><h2>Fecha:</h2></td>
        <td class="tablecell"><h2><?php echo $this->strdate; ?></h2></td>
    </tr>
    <tr>
        <td class="tablecell"><h2>Cotizaciones Realizadas desde 14/10/2014:</h2></td>
        <td class="tablecell"><h2><?php echo $this->cntquotation; ?></h2></td>
    </tr>
    <tr>
        <td colspan="2" class="box-title">
            <h3><i class="fa fa-user"></i>Información del Cliente</h3>
        </td>
    </tr>
    <tr>
        <td class="tablecell"><h2>E-mail:</h2></td>
        <td class="tablecell"><h2><?php echo $this->user->email; ?></h2></td>
    </tr> 
    <tr>
        <td class="tablecell"><h2>Nombre Completo:</h2></td>
        <td class="tablecell"><h2><?php echo $this->user->name; ?></h2></td>
    </tr>
    <tr>
        <td class="tablecell"><h2>Empresa:</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('company', $this->userprofile->profile))  {
                    if ($this->userprofile->profile['company'] != "")
                        echo $this->userprofile->profile['company'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>
        </td>
    </tr> 
    <tr>
        <td class="tablecell"><h2>Ciudad:</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('city', $this->userprofile->profile)) {
                    if ($this->userprofile->profile['city'] != "")
                        echo $this->userprofile->profile['city'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>            
        </td>
    </tr>  
    <tr>
        <td class="tablecell"><h2>Pa&iacute;s:</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('country', $this->userprofile->profile)) {
                    if ($this->userprofile->profile['country'] != "")
                        echo $this->userprofile->profile['country'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>            
        </td>
    </tr>  
    <tr>
        <td class="tablecell"><h2>Tel&eacute;fono:</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('phone', $this->userprofile->profile)) {
                    if ($this->userprofile->profile['phone'] != "")
                        echo $this->userprofile->profile['phone'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>            
        </td>
    </tr>   
    <tr>
        <td class="tablecell"><h2>Tel&eacute;fono Movil:</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('phone2', $this->userprofile->profile)) {
                    if ($this->userprofile->profile['phone2'] != "")
                        echo $this->userprofile->profile['phone2'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>            
        </td>
    </tr>   
    <tr>
        <td class="tablecell"><h2>Fax</h2></td>
        <td class="tablecell">
            <h2>
                <?php 
                if (array_key_exists('fax', $this->userprofile->profile)) {
                    if ($this->userprofile->profile['fax'] != "")
                        echo $this->userprofile->profile['fax'];
                    else 
                        echo "-"; 
                }
                ?>
            </h2>            
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table class="interna">
                <tr>
                    <th class="small">Cantidad</th>
                    <th class="normal">Imagen</th>
                    <th class="normal">Nombre</th>
                    <th class="normal">Descripción</th>
                    <th class="small">REF</th>
                    <th class="normal">Marcación</th>
                    <th class="small">Precio</th>
                    <th class="small">Precio con <br/ >Marcación</th>
                    <th class="small">Subtotal</th>
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
                        if (JFile::exists(JPATH_BASE."/".$imgproduct['path'])) {
                            $imagen = JURI::base() ."images/catalog/products/thumbnails/". end(@explode('/',$imgproduct['path'])); 
                        } else {
                            $imagen = JURI::root()."images/catalog/default_image.jpg";             
                        }
                        ?>
                        <tr>
                            <td class="small"><?php echo $item->cantidad; ?></td>
                            <td class="normal" align="center" style="background-color: #FFF; text-align: center;">
                                <a href="<?php 
                                    echo JURI::base().'component/catpromocional/getproduct/'.
                                    (int)$item->id_producto.$anaImagen;
                                ?>" target="_blank">
                                    <img src="<?php echo $imagen; ?>" width="100%"/>
                                </a>
                            </td>
                            <td class="normal"><?php echo $item->nombre; ?></td>
                            <td class="normal">
                            <?php
                                echo $item->descripcion.' '.$item->especificaciones;
                            ?>                                
                            </td>
                            <td class="small">                            
                                <a href="<?php 
                                    echo JURI::base().'component/catpromocional/getproduct/'.
                                    (int)$item->id_producto.$anaReferencia; ?>" target="_blank">
                                    <?php echo $item->referencia; ?>
                                </a>                                
                            </td>
                            <td class="normal">
                                <?php
                                // Loop Logos
                                if (count($logproduct) > 0) {
                                    foreach ($logproduct as $logo) {
                                        // Precio marcacion.
                                        $prclogo = $this->modelcq->getPriceMrcLogo($logo,$item);
                                        // Precio Marcación.
                                        $prcmarca += $prclogo;
                                        echo "<div class='div_marcacion'>";
                                        echo "<b>$ ".number_format($prclogo, 0, ",", ".") . "</b><br />" . $logo->tecnica . 
                                        "<br />" .$logo->unidad . "<br />";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="small">$ <?php echo number_format($prcproduct, 0, ",", "."); ?></td>
                            <td class="small">$ <?php echo number_format($prcmarca+$prcproduct, 0, ",", "."); ?>
                            </td>
                            <td class="small">$ <?php echo number_format(((ceil($prcmarca) + ceil($prcproduct)) * $item->cantidad), 0, ",", "."); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>            
        </td>
    </tr>

    <tr>
        <td colspan="4" id="tdterminos">
            <h1>T&eacute;rminos de Negociaci&oacute;n</h1>
        </td>
    </tr>
    <tr>
        <td colspan="4"><?php if (property_exists($this->qtext, 'terminos')) echo $this->qtext->terminos; ?></td>
    </tr>



    <!------------------------------------------------------------------------------------------------ -->
    <tr>
        <td colspan="4" class="box-title-executive"><h3><i class="fa fa-file-text-o"></i>Notas del cliente</h3></td>
    </tr>
    <tr>
        <td colspan="4" id="notes_executive">
            <p>
                <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->comentario; ?>
            </p>            
        </td>
    </tr>
    <?php
    // Validate Executive User.
    //d($this->user->groups);exit;
    if (in_array(10, $this->user->groups)) {
    ?>
        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-user"></i>Nombre Cliente</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_cliente; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-at"></i>Email Cliente</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->email_cliente; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-adjust"></i>Tipo Lead</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_tipo_lead; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-bolt"></i>Reemplaza al Lead</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->reemplazar_lead; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-sort-amount-asc"></i>Canal</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_canal; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-bullseye"></i>Primera Fuente</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->nombre_primera_fuente; ?>
                </p>            
            </td>
        </tr>

        <tr>
            <td colspan="4" class="box-title-executive"><h3><i class="fa fa-calendar"></i>Fecha Primera Fuente</h3></td>
        </tr>
        <tr>
            <td colspan="4" id="notes_executive">
                <p>
                    <?php if (property_exists($this->quotation, 'comentario')) echo $this->quotation->fecha_primera_fuente; ?>
                </p>            
            </td>
        </tr>
    <?php } ?>
    <!------------------------------------------------------------------------------------------------ -->

    <tr>
        <td colspan="4" id="greeting">
            <p>
                <?php if (property_exists($this->qtext, 'footer')) echo $this->qtext->footer; ?>
            </p>     
        </td>
    </tr>
</table>