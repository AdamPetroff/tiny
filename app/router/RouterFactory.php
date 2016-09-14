<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('<presenter>/<action>', 'Users:default');
		$router[] = new Route('<presenter>/<action>', 'Sign:in');
		$router[] = new Route('<presenter>/<action>', 'Sign:up');
		$router[] = new Route('<presenter>/<action>', 'Sign:out');
		$router[] = new Route('<presenter>/<action>', 'Profile:default');
		$router[] = new Route('<presenter>/<action>', 'Profile:edit');
		return $router;
	}

}
