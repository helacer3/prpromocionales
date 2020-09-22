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
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
// set Name Component
$component = "CatPromocional";
// fetch the view
$view = JRequest::getVar( 'view' , $component );
// Other controllers.
$otherControllers = array('executives','redimension','productfilters');
// Validate controller call
if (in_array($view, $otherControllers)) {
	require_once( JPATH_COMPONENT.'/controllers/'.$view.'.php' );
	// initiate the contoller class and execute the controller
	$controllerClass = $component."Controller".ucfirst($view);
	//echo "entra12";	
	$controllerCall = new $controllerClass;
} else {
	$controllerCall	= JControllerLegacy::getInstance($component);
}
$controllerCall->execute(JFactory::getApplication()->input->get('task'));
$controllerCall->redirect();