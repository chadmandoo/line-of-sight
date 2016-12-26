<?php

namespace Los\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class LosBootstrap
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
        $finder->files()->name('routes.json')->in('../src');
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

    /**
     * @return ContainerBuilder
     */
    public static function containerSetup()
    {
        $container = new ContainerBuilder();
        $container->register('entity.manager', 'Los\Core\Entity\EntityManagerWrapper');
        $container->register('serializer', 'Los\Core\Serializer\SerializerWrapper');

        return $container;
    }
}
