<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cosumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Inscripcion controller class.
 *
 * @since  1.6
 */
class Mundial_cosumel_2016ControllerInscripcion extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'inscripcions';
		parent::__construct();
	}
}
