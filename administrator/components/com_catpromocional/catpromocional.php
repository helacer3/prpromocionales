<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// No direct access to this file
defined('_JEXEC') or die;
 
// Get an instance of the controller prefixed by CatPromocional
$controller = JControllerLegacy::getInstance('CatPromocional');
 
// Perform the Request task and Execute request task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
// Redirect if set by the controller
$controller->redirect();