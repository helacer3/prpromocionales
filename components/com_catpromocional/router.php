<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_catpromocional
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

/**
 * Routing class from com_catpromocional
 *
 * @since  3.3
 */
class CatpromocionalRouter extends JComponentRouterBase
{
	/**
	 * Build the route for the com_catpromocional component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query)
	{
        //echo "<br /><pre>".var_dump($query)."</pre><br />";
		$segments = array();

		if (isset($query['task']))
		{
			if ($query['task'] == 'getproducts' || $query['task'] == 'catalogo') {
				$segments[0] = 'catalogo';
			} else {
				$segments[0] = $query['task'];
			}
			unset($query['task']);
		}

		if (isset($query['id']))
		{
			$segments[1] = $query['id'];
			unset($query['id']);
		}
                
        if (isset($query['bsc']))
		{
			$segments[] = $query['bsc'];
			unset($query['bsc']);
		}
                
                
        if (isset($query['p']))
		{
			$segments[] = $query['p'];
			unset($query['p']);
		}

		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}

        //echo "<br /><pre>".var_dump($segments)."</pre><br />";
		return $segments;
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		$total = count($segments);
		$vars = array();

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
		}

		// Var Task
		if ($segments[0] == 'catalogo') {
			$vars['task'] = 'getproducts';
		} else {
			$vars['task'] = $segments[0];
		}
		// Var Id Category or product.
		$vars['id'] = $segments[1];
		// Var Word Search.
		$vars['bsc'] = $segments[1];
		// Var page List Products.
		$vars['p'] = $segments[2];
        /*
		// View is always the first element of the array
		$count = count($segments);

		if ($count)
		{
			$count--;
			$segment = array_shift($segments);

			if (is_numeric($segment))
			{
				$vars['id'] = $segment;
			}
			else
			{
				$vars['task'] = $segment;
			}
		}

		if ($count)
		{
			$segment = array_shift($segments);

			if (is_numeric($segment))
			{
				$vars['id'] = $segment;
			}
		}
                */

		return $vars;
	}
}

/**
 * Build the route for the com_banners component
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function catpromocionalBuildRoute(&$query)
{
	$router = new BannersRouter;

	return $router->build($query);
}

/**
 * Parse the segments of a URL.
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function catpromocionalParseRoute($segments)
{
	$router = new BannersRouter;

	return $router->parse($segments);
}
