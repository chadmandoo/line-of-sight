<?php

define("APP_PATH", __DIR__);
define("APP_PATH_SRC", __DIR__.'/src');
define("APP_PATH_APP", __DIR__.'/app');
define("APP_PATH_CONFIG", __DIR__.'/app/config');
define("APP_PATH_CACHE", __DIR__.'/app/cache');

/**
 * Bootstrap application.
 */
require 'app/autoload.php';

$managerWrapper = new \Los\Core\Entity\EntityManagerWrapper(new \Los\Core\Config\LosConfig());

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($managerWrapper->getEntityManager());
