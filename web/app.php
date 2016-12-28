<?php
/**
 * @file
 */

define("APP_PATH", dirname(__DIR__));
define("APP_PATH_SRC", dirname(__DIR__).'/src');
define("APP_PATH_APP", dirname(__DIR__).'/app');
define("APP_PATH_CONFIG", dirname(__DIR__).'/app/config');

/**
 * Bootstrap application.
 */
require APP_PATH.'/app/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Finder\Finder;
use Los\Core\Http\LosKernel;

/**
 * Unleash the Kernel
 */
$kernel = new LosKernel(new ControllerResolver(), new ArgumentResolver(), new ContainerBuilder(), new Finder());
$response = $kernel->handle(Request::createFromGlobals());
$response->send();
