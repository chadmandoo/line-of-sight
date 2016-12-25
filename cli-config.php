<?php

require_once 'app/autoload.php';

$managerWrapper = new \Los\Core\Entity\EntityManagerWrapper();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($managerWrapper->getEntityManager());
