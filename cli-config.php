<?php

require_once 'app/autoload.php';

$managerWrapper = new \Los\Core\Entity\EntityManagerWrapper(new \Los\Core\Config\LosConfig());

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($managerWrapper->getEntityManager());
