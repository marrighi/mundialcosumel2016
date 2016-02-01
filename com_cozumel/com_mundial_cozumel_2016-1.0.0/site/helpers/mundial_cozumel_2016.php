<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cozumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class Mundial_cozumel_2016FrontendHelper
 *
 * @since  1.6
 */
class Mundial_cozumel_2016FrontendHelper
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_mundial_cozumel_2016/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_mundial_cozumel_2016/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Mundial_cozumel_2016Model');
		}

		return $model;
	}
}
