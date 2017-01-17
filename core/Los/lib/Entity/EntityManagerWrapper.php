<?php

namespace Los\Core\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerWrapper
 * @package Los\Core\Entity
 */
class EntityManagerWrapper
{
    private $entityManager;
    private $entityInfo;

    /**
     * EntityManagerWrapper constructor.
     * @param array      $config
     * @param EntityInfo $entityInfo
     */
    public function __construct($config, EntityInfo $entityInfo = null)
    {
        $this->entityInfo = $entityInfo;
        $dbConnect = $config->getConfig();

        $conn = array(
            'dbname' => $dbConnect['database']['dbname'],
            'user' => $dbConnect['database']['user'],
            'password' => $dbConnect['database']['password'],
            'host' => $dbConnect['database']['host'],
            'driver' => $dbConnect['database']['driver'],
            'port' => $dbConnect['database']['port'],
        );

        $config = Setup::createAnnotationMetadataConfiguration(array(APP_PATH_SRC), true);
        $this->entityManager = EntityManager::create($conn, $config);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Return entity repository.
     *
     * @param string $entityName
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepo($entityName)
    {
        $namespace = $this->entityInfo->getEntityInfoByNameSpace($entityName);

        return $this->entityManager->getRepository($namespace);
    }
}
