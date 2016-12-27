<?php

namespace Los\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class LosBootstrap
 *
 * @deprecated This class is already deprecated and will split the functions into own classes.
 * @package Los\Core
 */
class LosBootstrap
{
    /**
     * Set up Routes
     *
     * @return RouteCollection
     */
    public static function routeSetup()
    {
        $routeCollection = new RouteCollection();

        $entityLocations = array();
        $finder = new Finder();
        $finder->files()->name('routes.json')->in(APP_PATH_SRC);
        foreach ($finder as $file) {
            $entityLocations[] = $file->getRealPath();
        }

        foreach ($entityLocations as $location) {
            $routes = json_decode(file_get_contents($location), true);

            foreach ($routes as $route) {
                $routeAdd = new Route($route['path'], array('_controller' => $route['_controller']));
                $routeCollection->add($route['title'], $routeAdd);
            }
        }

        return $routeCollection;
    }
}
