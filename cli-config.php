<?php

define("APP_PATH", dirname(__DIR__));
define("APP_PATH_SRC", dirname(__DIR__).'/src');
define("APP_PATH_APP", dirname(__DIR__).'/app');
define("APP_PATH_CONFIG", dirname(__DIR__).'/app/config');
define("APP_PATH_CACHE", dirname(__DIR__).'/app/cache');

/**
 * Bootstrap application.
 */
require 'app/autoload.php';

$managerWrapper = new \Los\Core\Entity\EntityManagerWrapper(new \Los\Core\Config\LosConfig());

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($managerWrapper->getEntityManager());
