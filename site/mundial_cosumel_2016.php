<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cosumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('Mundial_cosumel_2016FrontendHelper', JPATH_COMPONENT . '/helpers/mundial_cosumel_2016.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Mundial_cosumel_2016');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
