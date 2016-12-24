<?php

namespace Los\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class LosBootstrap
 * @package Los\Core
 */
class LosBootstrap
{
    const CONFIG_PATH = '../app/config/config.json';

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
     * Bootstrap database.
     *
     * @return EntityManager
     */
    public static function database()
    {
        $db = json_decode(file_get_contents(self::CONFIG_PATH), true);

        $conn = array(
            'dbname' => $db['database']['dbname'],
            'user' => $db['database']['user'],
            'password' => $db['database']['password'],
            'host' => $db['database']['host'],
            'driver' => $db['database']['driver'],
            'port' => $db['database']['port'],
        );
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src"), true);

        return EntityManager::create($conn, $config);
    }
}
