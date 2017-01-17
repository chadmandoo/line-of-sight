<?php

namespace Los\Core\Config;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Finder\Finder;

/**
 * Class LosConfig
 * @package Los\Core\Cache
 */
class LosConfig
{
    /**
     * Configuration file
     *
     * @var
     */
    private $config;

    /**
     * Routes array
     *
     * @var
     */
    private $routes;

    /**
     * Entity Info Array
     *
     * @var
     */
    private $entityInfo;

    /**
     * LosConfig constructor.
     */
    public function __construct()
    {
        $this->config = json_decode(file_get_contents(APP_PATH_CONFIG.'/config.json'), true);

        if ($this->config['cache']) {
            $configCache = new ConfigCache(APP_PATH_CACHE.'/file.cache', true);

            if (!$configCache->isFresh()) {
                $this->setup();
                $resources['routes'] = $this->routes;
                $resources['entityInfo'] = $this->entityInfo;

                if (!empty($resources['routes']) || !empty($resources['entityInfo'])) {
                    $configCache->write(json_encode($resources));
                }
            } else {
                $cache = json_decode(file_get_contents(APP_PATH_CACHE.'/file.cache'), true);

                if (isset($cache['routes'])) {
                    $this->routes = $cache['routes'];
                }

                if (isset($cache['entityInfo'])) {
                    $this->entityInfo = $cache['entityInfo'];
                }
            }
        } else {
            $this->setup();
        }
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param mixed $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return mixed
     */
    public function getEntityInfo()
    {
        return $this->entityInfo;
    }

    /**
     * @param mixed $entityInfo
     */
    public function setEntityInfo($entityInfo)
    {
        $this->entityInfo = $entityInfo;
    }

    private function setup()
    {
        $this->routes = $this->generateRoutes();
        $this->entityInfo = $this->generateEntityInfo();
    }

    /**
     * Load routes and set it in the cache.
     */
    private function generateRoutes()
    {
        $routes = array();
        $controllerRoutes = array();
        $finder = new Finder();
        $finder->files()->name('routes.json')->in(APP_PATH_SRC);

        foreach ($finder as $file) {
            $controllerRoutes[] = $file->getRealPath();
        }

        foreach ($controllerRoutes as $location) {
            $routes = json_decode(file_get_contents($location), true);

            foreach ($routes as $route) {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    private function generateEntityInfo()
    {
        $entities = array();
        $entityFinder = new Finder();
        $entityFinder->files()->name('entity.json')->in(APP_PATH_SRC);

        foreach ($entityFinder as $file) {
            $entity = json_decode(file_get_contents($file->getRealPath()), true);

            if ($entity) {
                $entities += $entity;
            }
        }

        return $entities;
    }
}