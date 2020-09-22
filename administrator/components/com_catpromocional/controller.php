<?php
error_reporting(0);
ini_set('display_errors', 1);
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * General Controller of CatPromocional component
 */
class CatPromocionalController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) 
	{
		$view   = $this->input->get('view', 'CatPromocionals');
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', $view));
 
		// call parent behavior
		parent::display($cachable);
	}
        ////////////////////////////////////////////////////////////////////////
        // Get Scale Ranges
        ////////////////////////////////////////////////////////////////////////
        public function getScaleRanges(){
            // Create Var.
            $options = "<option value='0'>Seleccione Escala Rango</option>";
            // Obtengo el model.
            $model = $this->getModel('catasgcosto');
            $input = JFactory::getApplication()->input;
            // get input id.
            $id = $input->get('id', '0', 'int');
            // Get Range Scales.
            $escaleRanges = $model->getListScaleRanges($id);
            // Loop Ranges.
            foreach($escaleRanges as $range) {
                $options .= "<option value='".$range->id."'>".$range->nombre."</option>";
            }
            // Show String Options.
            echo $options;
        }
        ////////////////////////////////////////////////////////////////////////
        // Get Techniques By Product
        ////////////////////////////////////////////////////////////////////////
        public function getTechniquesByProduct(){
            // Create Var.
            $options = "<option value='0'>Seleccione Técnica</option>";
            // Obtengo el model.
            $model = $this->getModel('catprptecnica');
            $input = JFactory::getApplication()->input;
            // get input id.
            $id = $input->get('id', '0', 'int');
            // Get Range Scales.
            $escaleRanges = $model->getListTechniquesByProduct($id);
            // Loop Ranges.
            foreach($escaleRanges as $range) {
                $options .= "<option id='".$range->id_tecnica."' value='".$range->id_producto_tecnica."'>".$range->nombre."</option>";
            }
            // Show String Options.
            echo $options;
        }
        ////////////////////////////////////////////////////////////////////////
        // Get Units By Technique
        ////////////////////////////////////////////////////////////////////////
        public function getUnitsByTechnique(){
            // Create Var.
            $options = "<option value='0'>Seleccione Unidad</option>";
            // Obtengo el model.
            $model = $this->getModel('catprptecnica');
            $input = JFactory::getApplication()->input;
            // get input id.
            $id = $input->get('id', '0', 'int');
            // Get Range Scales.
            $escaleRanges = $model->getListUnitsByTechnique($id);
            // Loop Ranges.
            foreach($escaleRanges as $range) {
                $options .= "<option value='".$range->id."'>".$range->nombre."</option>";
            }
            // Show String Options.
            echo $options;
        }
        /******************************************************************************/
        // sort Providers
        /******************************************************************************/
        public function sortProviders() {
            // Obtengo el model.
            $model = $this->getModel('catordproducto');
            $input = JFactory::getApplication()->input;
            // get input data.
            $data  = $input->get('prv', array(), 'ARRAY');
            echo "<pre>"; var_dump($data); echo "</pre></br>";
            // Loop Array
            foreach ($data as $order => $id) {
                $model->setOrderProviders($id,$order);
            }
 
        }
        /******************************************************************************/
        // set Order Products
        /******************************************************************************/
        public function setOrderProducts() {
            // Obtengo el model.
            $model = $this->getModel('catordproducto');
            $input = JFactory::getApplication()->input;
            // get input id.
            $val = $input->get('val', '1', 'int');
            // Update Parameter.
            $model->setParameterOrder($val);
        }
}   