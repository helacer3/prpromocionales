<?php
/**
* @package Joomla.Administrator
* @subpackage com_catpromocional
*
* @copyright Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
 
// No direct access to this file
defined('_JEXEC') or die;
 
// import Joomla controller library
jimport('joomla.application.component.controller');
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);*/
error_reporting(0);
require_once JPATH_COMPONENT . '/kint/Kint.class.php';
/**
 * CatPromocional Component Controller
 *
 * @since   0.0.1
 */
class CatPromocionalController extends JControllerLegacy
{
    // Set Class Var Items Pagination
    protected $items = 12;    
    ////////////////////////////////////////////////////////////////////////////
    // Construct Controller
    ////////////////////////////////////////////////////////////////////////////  
    public function __construct($options = array()) {
        @session_start();
        $app = JFactory::getApplication();
        $app->setTemplate('Prpromocionales');
        parent::__construct($options);
    }
    ////////////////////////////////////////////////////////////////////////////
    // get update Cart Ajax
    ////////////////////////////////////////////////////////////////////////////
    public function getUpdateCartAjax() {
        $session = JFactory::getSession();
        $lstproducts = $session->get('addproduct');
        //var_dump($lstproducts);exit;
        $view = $this->getView('showcart','html');
        $view->assignRef('lstproducts',$lstproducts);
        $view->display();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Products Search Ajax
    ////////////////////////////////////////////////////////////////////////////
    public function getproductsSearchAjax() {
        $input = JFactory::getApplication()->input;
        $buscador = $input->getCmd('bsc','');
        $view = $this->getView('listproductsajax','html');
        $modelp = $this->getModel('products');
        $modelc = $this->getModel('categories');
        $PrdCategory = $modelp->getProductsCategory($id);
        $view->assignRef('PrdCategory',$PrdCategory);
        $view->display();
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Products
    ////////////////////////////////////////////////////////////////////////////
    public function getproducts($arrProducts = array()) {
        // registrate Google Analytics Session
        $this->createGASession();
        // Start vars.
        $input = JFactory::getApplication()->input;
        $id = $input->getInt('id',0);
        $pag = $input->getInt('p',1);
        // Get User Info.
        $user = JFactory::getUser();
        // Validate filter - reset vars
        if ($id > 0) {
            $wrdSearch = '';
            $_SESSION['flt_products'] = array();
        }
        else $wrdSearch =  $input->getString('bsc','');
        // get View and models.
        $view = $this->getView('listproducts','html');
        $modelp =  $this->getModel('products');
        $modelc =  $this->getModel('categories');
        $modelpr = $this->getModel('promocional');
        $modeldb = $this->getModel('dbmethods');
        // Search Phrase Register.
        $modelpr->searchPhraseRegister($wrdSearch,$modeldb);
        // Validate array Session.
        if (isset($_SESSION['flt_products'])){ 
            if (count($arrProducts) == 0 && count((array)$_SESSION['flt_products']) > 0) {
                $arrProducts = (array)$_SESSION['flt_products'];
            }
        }
        // Get Pagination.
        $PrdPagination = $this->getPagination($pag);
        // Get cantity pages for category.
        $CntPages = $this->getCategoryPages($id,$PrdPagination,$wrdSearch,$arrProducts,$modelp);
        // Get Info for Pagination tpl
        $InfPagination = $this->getInfoPagination($CntPages,$pag);        
        // Get Product Info
        if($id > 0 || $wrdSearch != "" || count($arrProducts) > 0) {
            $PrdCategory = $modelp->getProductsCategory($id,$PrdPagination,$wrdSearch,$arrProducts,1);
        } else {
            $PrdCategory = $modelp->getProductsOutstanding($PrdPagination,1);
        }
        // Validate redirect.
        $this->redirectHomeProducts($id,$wrdSearch,$PrdCategory);
        // Get Category InfogetCategoryPages
        $InfCategory = $modelc->getInfoCategory($id);
        // Get Category Images
        $ImgCategory = $modelc->getImagesElement($id,2);
        // Assign Vars to View
        $view->assignRef('Id',$id);
        $view->assignRef('Pag',$pag);
        $view->assignRef('user',$user);
        $view->assignRef('CntPages',$CntPages);
        $view->assignRef('InfPagination',$InfPagination);
        $view->assignRef('InfCategory',$InfCategory);
        $view->assignRef('PrdCategory',$PrdCategory);
        $view->assignRef('ImgCategory',$ImgCategory);
        $view->assignRef('WrdSearch',$wrdSearch);
        $view->display();	
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Quotation
    ////////////////////////////////////////////////////////////////////////////
    public function getProduct() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $id = $input->getCmd('id',0);
        // Get User Info.
        $user = JFactory::getUser();
        // Get Models.
        $model = $this->getModel('products');
        $modelc = $this->getModel('categories');
        $modelqp = $this->getModel('quotationprices');
        $infProduct = $model->getProductInfo($id);   
        $imgProduct = $modelc->getImagesElement($id,1);
        $ranScale = $modelqp->getPricesRangesScaleProduct($id);
        // registrate Google Analytics Session
        $this->createGASession();
        // Get View.
        $view = $this->getView('cotizador','html');
        $view->assignRef('idproduct',$id);
        $view->assignRef('user',$user);
        $view->assignRef('ranScale',$ranScale);
        $view->assignRef('infproduct',$infProduct);
        $view->assignRef('imgproduct',$imgProduct);
        $view->display();	
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Techniques By Logo
    ////////////////////////////////////////////////////////////////////////////
    public function gettechniquesbyLogo() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $cantidad = $input->getCmd('cantidad',0);
        $view = $this->getView('tecnicas','html');
        $view->assignRef('cantidad',$cantidad);
        $view->display();	
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Techniques By Logo And Product
    ////////////////////////////////////////////////////////////////////////////
    public function gettechniquesbyLogoAndProduct() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $id = $input->getCmd('id',0);
        $productid = $input->getCmd('productid',0);
        $cantidad = $input->getCmd('cantidad',0);
        $view = $this->getView('tecnicasproducto','html');
        $view->assignRef('id',$id);
        $view->assignRef('productid',$productid);
        $view->assignRef('cantidad',$cantidad);
        $view->display();	
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Units By Technique
    ////////////////////////////////////////////////////////////////////////////
    public function getunitsbyTechnique() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $id = $input->getCmd('id',0);
        $view = $this->getView('unidades','html');
        $view->assignRef('id',$id);
        $view->display();	
    }
    ////////////////////////////////////////////////////////////////////////////
    // add Product Quotation.
    ////////////////////////////////////////////////////////////////////////////
    public function addProductQuotation() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        $productid = $input->getInt('productid',0);
        $form = $input->getVar('form');
        parse_str($form, $formArray);
        $model = $this->getModel('products');
        $productInfo = $model->getProductSingleInfo($productid);
        $sesProducts = $this->addProductSession($productid,$productInfo,$formArray);
        //d($productid);
        // Get View
        $view = $this->getView('productocotizado','html');
        $view->assignRef('productid',$productid);
        $view->assignRef('productname',$productInfo['nombre']);
        $view->assignRef('sesproducts',$sesProducts);
        $view->display();
    }
    ////////////////////////////////////////////////////////////////////////////
    // add User Quotation.
    ////////////////////////////////////////////////////////////////////////////
    public function addquser() {
        // Get Id Product.
        $input = JFactory::getApplication()->input;
        $id = $input->getCmd('id',0);
        // add Items to cart.
        $this->addItemsToCartSession($id);
        // Get Confirm View
        $this->getconfirm();
    }    
    ////////////////////////////////////////////////////////////////////////////
    // get Confirm View.
    ////////////////////////////////////////////////////////////////////////////
    public function getconfirm() {
        // Validate product session.
        if (count($this->getSessionVar('addproduct')) > 0
            || count($this->getSessionVar('crtproduct')) > 0) {
            // Get User Info.
            $user = JFactory::getUser();
            // Validate user no authenticated.
            if ($user->guest) {
                // Get Model.
                $modelg = $this->getModel('generals');
                // Get Sectors.
                $sectors = $modelg->getSectors();
                // Get Countries.
                $countries = $modelg->getCountries();
                // Get View.
                $view = $this->getView('UserCotiza','html');
                $view->assignRef('sectors',$sectors);
                $view->assignRef('countries',$countries);
                $view->display();
            // Authenticated user forwards to confirmation
            } else {
                $this->getqconfirm();
            }
        } else {
            // Redirect to root products.
            $app = JFactory::getApplication(); 
            $app->redirect('index.php');
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Quotation Confirm.
    ////////////////////////////////////////////////////////////////////////////
    public function getqconfirm() {
        // Get User Info.
        $user = JFactory::getUser();
        // Validate user no authenticated.
        if ($user->guest) {            
            // Get View.
            $view = $this->getView('UserCotiza','html');
            $view->display();
        } else {
            // Get Session Joomla.
            $session = JFactory::getSession();
            // Get Models.
            $model = $this->getModel('promocional');
            $modelg = $this->getModel('generals');
            // add Item to Cart Session.
            $this->addItemsToCartSession(0);
            // Get Session Cart.
            $sesproduct = $session->get('crtproduct');
            // Get List Type Lead.
            $tlead = $model->getLedTypeList(); 
            // Get List Channels.
            $lcanal = $model->getChannelList(); 
            // Get List Source First.
            $sfirst = $model->getSourceFirst();
            // Get List Cities.
            $lcities = $modelg->getCities();
            // Get View.
            $view = $this->getView('CnfCotiza','html');
            $view->assignRef('user',$user);
            $view->assignRef('lstproduct',$sesproduct);
            $view->assignRef('lstlead',$tlead);
            $view->assignRef('lcanal', $lcanal);
            $view->assignRef('lstcities',$lcities);
            $view->assignRef('sfirst', $sfirst);
            $view->display();
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Quotation Generated.
    ////////////////////////////////////////////////////////////////////////////
    public function getqgenerated() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        // Get user
        $user = JFactory::getUser();
        // Create array.
        $arrform = array();
        // Get info form.
        $arrform['nota']     = $input->getString('fco_nota','');
        $arrform['name']     = $input->getString('fco_name','');
        $arrform['email']    = $input->getString('fco_email','');
        $arrform['tled']     = $input->getInt('fco_tled',0);
        $arrform['rlead']    = $input->getString('fco_rlead','');
        $arrform['pcanal']   = $input->getInt('fco_pcanal',0);
        $arrform['pfuente']  = $input->getInt('fco_pfuente',0);
        $arrform['fpfuente'] = $input->getCmd('fco_fpfuente','');

        $arrform['empresa']  = $input->getString('fco_empresa','');
        $arrform['ciudad']   = $input->getString('fco_ciudad','');
        $arrform['telefono'] = $input->getString('fco_telefono','');
        //echo "<pre>"; var_dump($arrform); echo "</pre>";exit;
        // Get Models Quotation.
        $modelq = $this->getModel('quotation');
        $modelqp = $this->getModel('quotationprices');
        $modeldb = $this->getModel('dbmethods');
        $modelcq = $this->getModel('cnsquotation');
        // Is Blocked Domain
        if (
            (int)$modelcq->getIsBlockedDomain($user->email) > 0 ||
            (int)$modelcq->getIsBlockedDomain($arrform['email']) > 0
        ) {
            $msg = "La generación de cotizaciones desde el dominio"
            . " del usuario se encuentra bloqueada. Para mayor información .....";
            $this->quotationsend($msg);
        }// Is Limited????
        else if ((int)$modelcq->getLimitQuotationByUser($user->id) == 0) {
            $msg = "El usuario ha llegado al limite de cotizaciones. "
            . "Para mayor información .....";
            $this->quotationsend($msg);
        } 
        else {
            // Update Quotation limit.
            $modelcq->updateLimitQuotationByUser($user->id);
            // Get Session Joomla.
            $session = JFactory::getSession();
            // Get Session Cart.
            $sesquotation = $session->get('crtproduct');
            // Create Quotation.
            $id = $modelq->createQuotation(
                    $sesquotation,$arrform,$modelqp,$modeldb);
            // Create Quotation Session.
            $this->createQSession($id,$arrform['email'],$user->email);
            // Send Quotation.
            $this->generateMailQuotation($id);
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Quotation Send
    ////////////////////////////////////////////////////////////////////////////
    public function quotationsend($message = "") {
        // Get User Info.
        $user = JFactory::getUser();
        // Get View.
        $view = $this->getView('sndcotiza','html');
        $view->assignRef('message',$message);
        $view->assignRef('usr_email',$user->email);
        $view->display();
    }
    ////////////////////////////////////////////////////////////////////////////
    // generate Mail Quotation.
    ////////////////////////////////////////////////////////////////////////////
    public function generateLocalQuotation() {
        // Get Input.
        $input = JFactory::getApplication()->input;
        // Get info form.
        $id = $input->getInt('id',0);
        // Validate Id.
        if ($id > 0) {
            // Generate Quotation.
            $this->generateMailQuotation($id);
        } else {
            $app = JFactory::getApplication(); 
            $link = JRoute::_('index.php?option=com_catpromocional&task=listproducts'); 
            $msg = 'La cotización seleccionada no se encuentra disponible'; 
            $app->redirect($link, $msg, $msgType='message');
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // generate Mail Quotation.
    ////////////////////////////////////////////////////////////////////////////
    public function generateMailQuotation($id) {
        // create Var.
        $couName = "";
        // Get user
        $user = JFactory::getUser();
        // Get Models.
        $modelg = $this->getModel('generals');
        $modelp = $this->getModel('products');
        $modelcq = $this->getModel('cnsquotation');
        // Get Quotation Text.
        $qtext = $modelcq->getQuotationText();
        // Get Quotation.
        $quotation = $modelcq->getQuotation($id);
        $itemQuotation = $modelcq->getQuotationItems($id);
        // Get Count Quotations.
        $cntquotation = $modelcq->getCountQuotation($user->id);
        // Get String Date. 
        $strdate = $modelcq->getStringDate($quotation->fecha);
        
        $userProfile = JUserHelper::getProfile( $user->id );
        // get Country Name
        if (array_key_exists('country', $userProfile->profile)) {
            $couName = $modelg->getCountryName($userProfile->profile['country']);
        }

        // Get View.
        $view = $this->getView('cotizacion','html');
        $view->assignRef('modelp',$modelp);
        $view->assignRef('modelcq',$modelcq);
        $view->assignRef('qtext',$qtext);
        $view->assignRef('quotation',$quotation);
        $view->assignRef('cntquotation',$cntquotation);
        $view->assignRef('strdate',$strdate);
        $view->assignRef('user',$user);
        $view->assignRef('couname',$couName);
        $view->assignRef('userprofile',$userProfile);
        $view->assignRef('itemquotation',$itemQuotation);
        // Display View.
        $view->display();
    }
    ////////////////////////////////////////////////////////////////////////////
    // send Mail Quotation.
    ////////////////////////////////////////////////////////////////////////////
    public function sendMailQuotation() {
        // Get Mailer.
        $mailer = JFactory::getMailer();
        // Get Input.
        $input = JFactory::getApplication()->input;
        // Get Models.
        $model = $this->getModel('quotation');
        $modelcq = $this->getModel('cnsquotation');
        // Get Info Send Quotation
        $quotext = $modelcq->getQuotationText();
        // Get info form.
        $body = $input->get('body', '', 'RAW');
        // Set Sender
        $config = JFactory::getConfig();
        $sender = array($config->get( 'mailfrom' ),$config->get( 'fromname' ));
        $mailer->setSender($sender);
        // generate Array RC.
        $arrRC = array($this->getSessionVar('quotation_coruser'));
        // generate Array CC.
        $arrCC = array(
            $quotext->correo_destino1, $quotext->correo_destino2,
            $quotext->correo_destino3, $quotext->correo_destino4,
            $quotext->correo_destino5, $quotext->correo_destino6,
            $quotext->correo_destino7, $quotext->correo_destino8
        );
        // clean arrCC
        $arrCCReal = array_diff($arrCC, $arrRC); 
        // Set Recipient.
        $mailer->addRecipient($arrRC);
        // Set CCopy.
        $mailer->addCC($arrCCReal);
        // other Info.
        $mailer->setSubject("Proyecta-T Imprimir Cotización - ".$this->getSessionVar('quotation_id'));
        $mailer->setBody($body);
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $send = $mailer->Send();
        // clear sessions
        $model->clearSession();
        // Send Mail Validate.
        if ( $send !== true ) {
            $this->quotationsend('Error enviando cotización: ' . $send->__toString());
        } else {
            $this->quotationsend();
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////// SESSIONS /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    // Remove Product Session
    ////////////////////////////////////////////////////////////////////////////
    public function rmProductSession($sesproduct,$productid) {  
        if (count($sesproduct)) {
            foreach($sesproduct as $key => $product) {
                if($product['idproduct'] == $productid) {
                    unset($sesproduct[$key]);
                }
            }
        }
        // Return session.
        return $sesproduct;
    }
    ////////////////////////////////////////////////////////////////////////////
    // add Product Session
    ////////////////////////////////////////////////////////////////////////////
    public function addItemsToCartSession($productid) {
        // Get Session Joomla.
        $session = JFactory::getSession();
        // Get Session Products.
        $sesproduct = $session->get('addproduct');
        // Get Session Cart.
        $sescart = $this->rmProductSession(
            $session->get('crtproduct'),$productid);
        // Add Session Product to cart.
        $sesmerge = array_merge((array)$sescart,(array)$sesproduct);
        $sesmerge = array_unique($sesmerge, SORT_REGULAR);
        // Set session Cart.
        $session->set('crtproduct',$sesmerge);
    }
    ////////////////////////////////////////////////////////////////////////////
    // add Product Session
    ////////////////////////////////////////////////////////////////////////////
    public function addProductSession($productId,$productInfo,$form) {
        $session = JFactory::getSession();
        $sesProducts = $this->getSessionVar('addproduct');
        // Validate form
        if ($form['prd_canproductos'] > 0 && 
            $productInfo['cnt_minima'] <= $form['prd_canproductos']) {
            // Assign Values
            $modelp = $this->getModel('promocional');
            // Set index
            $indAsignar = (count($sesProducts) > 0)? max(array_keys($sesProducts))+1: 1;
            // set session.
            $sesProducts[$indAsignar]['idproduct']  = $productId;
            $sesProducts[$indAsignar]['namproduct'] = $productInfo['nombre'];
            $sesProducts[$indAsignar]['desproduct'] = $productInfo['descripcion'];
            $sesProducts[$indAsignar]['refproduct'] = $productInfo['referencia'];
            $sesProducts[$indAsignar]['imgproduct'] = $productInfo['path'];
            $sesProducts[$indAsignar]['cntproduct'] = $form['prd_canproductos'];
            $sesProducts[$indAsignar]['cntlogos']   = $form['prd_canlogos'];
            // for logos.
            if ((int)$form['prd_canlogos'] > 0) {
                for ($l=1; $l <= $form['prd_canlogos']; $l++) {
                    // Get Names.
                    $techniquename = $modelp->getTechniqueName($form['prd_tecnica'][$l]);
                    $unitname = $modelp->getUnitName($form['prd_unidad'][$l]);
                    // Add Session Values.
                    $sesProducts[$indAsignar]['logo'][$l]['nombre']        = "logo ".$l;
                    $sesProducts[$indAsignar]['logo'][$l]['tecnica']       = $form['prd_tecnica'][$l];
                    $sesProducts[$indAsignar]['logo'][$l]['unidad']        = $form['prd_unidad'][$l];
                    $sesProducts[$indAsignar]['logo'][$l]['tecnicanombre'] = $techniquename;
                    $sesProducts[$indAsignar]['logo'][$l]['unidadnombre']  = $unitname;
                }
            } else {
                $sesProducts[$indAsignar]['logo'][1]['nombre']        = "No aplica";
                $sesProducts[$indAsignar]['logo'][1]['tecnica']       = 0;
                $sesProducts[$indAsignar]['logo'][1]['unidad']        = 0;
                $sesProducts[$indAsignar]['logo'][1]['tecnicanombre'] = "No aplica";
                $sesProducts[$indAsignar]['logo'][1]['unidadnombre']  = "No aplica";                
            }
            //d($sesProducts);
            // Set Session
            $sesProducts = array_unique($sesProducts, SORT_REGULAR);
            $session->set('addproduct',$sesProducts);
        }
        //return Session
        return $sesProducts;
    }  
    ////////////////////////////////////////////////////////////////////////////
    // get Session Var
    ////////////////////////////////////////////////////////////////////////////
    public function getSessionVar($nameSession) {
        $session = JFactory::getSession();
        $addproduct = $session->get($nameSession);
        if ($addproduct) 
            return $addproduct;
        else
            return $session->set($nameSession);
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Session Var
    ////////////////////////////////////////////////////////////////////////////
    public function removeProductCart() {
        // get Vars.
        $input = JFactory::getApplication()->input;
        $id = $input->getInt('id',0);
        $s = $input->getInt('s',0);
        // Validate name session.
        $sesName1 = "crtproduct";
        $sesName2 = "addproduct"; 
        // get Session.
        $session = JFactory::getSession();
        $sesProducts1 = $this->getSessionVar($sesName1);
        $sesProducts2 = $this->getSessionVar($sesName2);
        //echo "<br/><pre>"; var_dump($sesProducts); echo "</pre>";
        // remove position.
        unset ($sesProducts1[$id]);
        unset ($sesProducts2[$id]);
        // Set Session.
        $session->set($sesName1,$sesProducts1);        
        $session->set($sesName2,$sesProducts2);        
        //$sesNueva = $this->getSessionVar($sesName);
    }
    ////////////////////////////////////////////////////////////////////////////
    // create Google Analytics Session
    ////////////////////////////////////////////////////////////////////////////
    public function createGASession() {
        // get Vars.
        $input = JFactory::getApplication()->input;         
        if ($input->getString('utm_source','') != '') {       
            // Get Session Joomla.
            $session = JFactory::getSession();
            // Set session Quotation.
            $session->set('utm_source',   $input->getString('utm_source',''));
            $session->set('utm_medium',   $input->getString('utm_medium',''));
            $session->set('utm_term',     $input->getString('utm_term',''));
            $session->set('utm_content',  $input->getString('utm_content',''));
            $session->set('utm_campaign', $input->getString('utm_campaign',''));
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    // create Quotation Session
    ////////////////////////////////////////////////////////////////////////////
    public function createQSession($id,$cor1,$cor2) {
        // Get Session Joomla.
        $session = JFactory::getSession();
        // Set session Quotation.
        $session->set('quotation_id',$id);
        $session->set('quotation_cordig',$cor1);
        $session->set('quotation_coruser',$cor2);
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    //////////////////////////////// PAGINATION ////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    // get Pagination
    ////////////////////////////////////////////////////////////////////////////
    public function getPagination($pag) {
        // Create array
        $arrpagination = array();
        $arrpagination[0] = 0;
        $arrpagination[1] = $this->items;
        // Validate pagina.
        if ($pag > 1) {
            $arrpagination[0] = ($this->items*($pag-1));
        }
        // Return array.
        return $arrpagination;
    }
    ////////////////////////////////////////////////////////////////////////////
    // get Info Pagination
    ////////////////////////////////////////////////////////////////////////////
    public function getInfoPagination($CntPages,$pag) {
        $arrInfo = array();
        $arrInfo['ini'] = 1;
        $arrInfo['prev'] = 1;
        $arrInfo['next'] = $pag+1;
        $class = "";
        // Validate prev pag.
        if ($pag > 1) {
          $arrInfo['prev'] =  $pag-1; 
        }
        // Validate Show numbers
        if ($pag > 3){
            $arrInfo['ini'] = $pag - 2;
        }
        // Validate next pag
        if ($pag == $CntPages){
          $arrInfo['next'] = $pag; 
        }
        // Return Array
        return $arrInfo;
    } 
    ////////////////////////////////////////////////////////////////////////////
    // get Category Pages
    ////////////////////////////////////////////////////////////////////////////
    public function getCategoryPages($id,$PrdPagination,$wrdSearch,$arrProducts,$modelp) {
        if ($id == 0 && count($arrProducts) == 0)
            $CntProducts = $modelp->getProductsOutstanding($PrdPagination,0);
        else
            $CntProducts = $modelp->getProductsCategory($id,$PrdPagination,$wrdSearch,$arrProducts,0);
        return ceil($CntProducts / $this->items);
    }
    ////////////////////////////////////////////////////////////////////////////
    // redirect Home Products
    ////////////////////////////////////////////////////////////////////////////
    private function redirectHomeProducts($id,$wrdSearch,$PrdCategory) {
        // echo "aca ".count($PrdCategory);
        if (count($PrdCategory) == 0 && ($id > 0 || trim($wrdSearch) != "")) {
            $app = JFactory::getApplication(); 
            $link =  JRoute::_('index.php?option=com_catpromocional&task=getproducts');
            $msg = 'No se encontraron productos que coincidan con la búsqueda'; 
            $app->redirect($link, $msg, $msgType='message');
        }
    }
}