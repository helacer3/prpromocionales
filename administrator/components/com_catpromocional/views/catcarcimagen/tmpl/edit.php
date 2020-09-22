<!--
/*
 * jQuery File Upload Plugin Demo 9.1.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<?php
defined('_JEXEC') or die('Restricted access');
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
$document = JFactory::getDocument();
//echo $this->baseurl.'administrator/components/com_catpromocional/media/css/default.css';exit;
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/upload/down/css/bootstrap.min.css');
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/upload/down/css/blueimp-gallery.min.css');
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/upload/css/style.css');
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/upload/css/jquery.fileupload.css');
$document->addStyleSheet($this->baseurl.'/components/com_catpromocional/media/upload/css/jquery.fileupload-ui.css');
?>
<?php /*
<noscript><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/components/com_catpromocional/media/upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/components/com_catpromocional/media/upload/css/jquery.fileupload-ui-noscript.css"></noscript> */ ?>
<br /><br /><br /><br /><br />
<div class="header">
    <div class="title">Cargador de im&aacute;genes Cat&aacute;logo: <span>Proyecta T</span></div>
</div>
<div class="container">
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Agregar im&aacute;genes</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Iniciar Carga</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancelar carga</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Eliminar im&aacute;genes</span>
                </button>
                <a href="index.php?option=com_catpromocional&view=catpromocionals" 
                    class="btn btn-info" role="button"
                    style="float:right; margin-left: 8px;">
                        Ir a reporte productos
                </a>
                <a href="index.php?option=com_catpromocional&task=redimension.resizeImagesProducts" 
                    class="btn btn-info" role="button"
                    style="float:right; margin-left: 8px;">
                        Generar Imágenes Slide
                </a>
                <a href="index.php?option=com_catpromocional&task=redimension.generateThumbnailsProducts" 
                    class="btn btn-info" role="button"
                    style="float:right; margin-left: 8px;">
                        Generar Imágenes Thumbnails
                </a>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Cargar</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancelar</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Eliminar imagen</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<?php
$url = $this->baseurl.'/components/com_catpromocional/media/upload';
?>
<script src="<?php echo $url; ?>/down/js/jquery.min.js"></script>
<script src="<?php echo $url; ?>/down/js/tmpl.min.js"></script>
<script src="<?php echo $url; ?>/down/js/load-image.all.min.js"></script>
<script src="<?php echo $url; ?>/down/js/canvas-to-blob.min.js"></script>
<script src="<?php echo $url; ?>/down/js/bootstrap.min.js"></script>
<script src="<?php echo $url; ?>/down/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo $url; ?>/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo $url; ?>/js/jquery.iframe-transport.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-process.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-image.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-video.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo $url; ?>/js/jquery.fileupload-ui.js"></script>
<script src="<?php echo $url; ?>/js/main.js"></script>