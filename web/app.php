<?php

/**
 * @file
 */

define("APP_PATH", dirname(__DIR__));
define("APP_PATH_SRC", dirname(__DIR__).'/src');
define("APP_PATH_APP", dirname(__DIR__).'/app');
define("APP_PATH_CONFIG", dirname(__DIR__).'/app/config');
define("APP_PATH_CACHE", dirname(__DIR__).'/app/cache');

/**
 * Bootstrap application.
 */
require APP_PATH.'/app/autoload.php';

/**
 * Bootstrap configuration
 */

/**
 * Unleash the Kernel
 */
$kernel = new \Los\Core\Http\LosKernel(new \Symfony\Component\HttpKernel\Controller\ControllerResolver(), new \Symfony\Component\HttpKernel\Controller\ArgumentResolver(), new \Symfony\Component\DependencyInjection\ContainerBuilder(), new Los\Core\Config\LosConfig(), new \Symfony\Component\Finder\Finder());
$response = $kernel->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
$response->send();
