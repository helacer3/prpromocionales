<?php
defined('_JEXEC') or die;
// Get template path.
$app    = JFactory::getApplication();
$path   = JURI::base(true).'/templates/'.$app->getTemplate();
// Get general Model.
require_once JPATH_COMPONENT_SITE. '/models/generals.php';
//Import filesystem libraries. Perhaps not necessary, but does not hurt
jimport('joomla.filesystem.file');
// Products Category Count.
if (count($this->PrdCategory) > 0) {
?>
    <!-- inicio de las categorias de los productos-->
    <div id="productosCategoria">
        <h2 id="categoria">
            <?php
            // Validate Category name
            if (isset($_SESSION['flt_products']) && count(($_SESSION['flt_products'])) > 0) 
                echo "Resultados B&uacute;squeda";
            else if (trim($this->WrdSearch) != "")
                echo $this->WrdSearch;
            else if ($this->Id == 0)
                echo "Productos Destacados";
            else if (isset($this->InfCategory))
                echo $this->InfCategory->nombre;
            ?>
        </h2>
        <?php
        // Validate Category id.
        if ($this->Id > 0) {
        ?>
            <?php
            // Loop Images Category.
            if (isset($this->ImgCategory)) {
                foreach ($this->ImgCategory as $imgcategory) {
            ?>
                <div class="tipo"><img src="<?php echo JURI::root().$imgcategory->path; ?>" width="100%"/></div>
            <?php
                }
            }
            ?>	
            <div id="textoTipo">
                <?php
                // Validate category description
                if (isset($this->InfCategory))
                    echo $this->InfCategory->descripcion;
                ?>
            </div>
        <?php } // Close if category id ?>
        <div id="filtros">
            <div id="filtroLista"><img src="<?php echo $path; ?>/img/lista.png" style="display:none;"/>
                <img src="<?php echo $path; ?>/img/lista_over.png">
            </div>
            <div id="flitroGrupo"><img src="<?php echo $path; ?>/img/grupo.png"/>
                <img src="<?php echo $path; ?>/img/grupo_over.png" style="display:none;">
            </div>
        </div>
        <ul class="productoCategoriaUl center">
            <?php
            // Loop Products Category.
            foreach ($this->PrdCategory as $prdcategory) {
            ?>
            <li class="productCategoriaGrupo">
                <a class="lnk_image lnk_viewproduct" id="lpi_<?php echo $prdcategory->id; ?>" 
                    href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=getproduct&id='.$prdcategory->id); ?>">
                    <img class="prdGrupo" src="<?php
                        if (JFile::exists(JPATH_BASE."/".$prdcategory->path)) {
                            echo JURI::root()."/".$prdcategory->path; 
                        } else {
                            echo JURI::root()."images/catalog/default_image.jpg";             
                        }
                    ?>" width="100%"/>
                </a>
                <h5 class="nombrePrdGrupo">
                <?php
                    echo CatpromocionalModelGenerals::getFormatString($prdcategory->nombre);
                ?>                    
                </h5>
                <h5 class="descripcionPrdGrupo">
                <?php
                    echo CatpromocionalModelGenerals::getFormatString($prdcategory->descripcion);
                ?>
                </h5>
                <div class="cotizarGrupo">
                    <a href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=getproduct&id='.$prdcategory->id); ?>"
                        class="lnk_viewproduct" id="lpb_<?php echo $prdcategory->id; ?>">
                        COTIZAR
                    </a>
                </div>
                <?php
                // Validate Executive User.
                if (in_array(10, $this->user->groups)) {
                ?>
                <div class="cotizarGrupo hidebutton">
                    <a href="<?php echo JRoute::_('index.php?option=com_catpromocional&task=disableProduct&id='.
                    $prdcategory->id.'&view=executives&v=1'); ?>">
                        OCULTAR
                    </a>
                </div>
                <?php } ?>
            </li>
            <?php
            }
            ?>
        </ul>
        <?php
        // Validate Category id.
        if ($this->Id > 0 || (isset($_SESSION['flt_products']) && count(($_SESSION['flt_products'])) > 0)) {
        ?>
            <section class="paginacion">
                <ul>
                    <li><i class="fa fa-chevron-circle-left"></i></li>
                    <?php
                    // Generate Pagination.
                    for($i=$this->InfPagination['ini'];$i<($this->InfPagination['ini']+5);$i++) {
                        if ($i == $this->Pag) $class = "active"; else $class = "";
                        // Generate Url.
                        $url = "index.php?option=com_catpromocional&task=getproducts";
                        // Add Category Id.
                        if (isset($this->InfCategory)) 
                            $url .= "&id=".$this->InfCategory->id;
                        else
                            $url .= "&id=0"; 
                        // Add WrdSearch
                        if ((int)$this->WrdSearch != 0) 
                            $url .= "&bsc=".$this->WrdSearch;
                        // Add p{age
                        $url .= "&p=".$i;
                        // Validate page exist.
                        if ($i <= $this->CntPages) {
                    ?>
                    <li>
                        <a class="<?php echo $class; ?>" href="<?php echo JRoute::_($url);?>"><?php echo $i; ?></a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li><i class="fa fa-chevron-circle-right"></i></li>
                </ul>
            </section>
        <?php } ?>
    </div>
<?php
}
?>