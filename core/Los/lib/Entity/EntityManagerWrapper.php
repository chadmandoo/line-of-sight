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
     * @param EntityInfo $entityInfo
     */
    public function __construct(EntityInfo $entityInfo = null)
    {
        $this->entityInfo = $entityInfo;
        // @TODO throw an exception if this doesnt work.
        $db = json_decode(file_get_contents(APP_PATH_CONFIG.'/config.json'), true);

        $conn = array(
            'dbname' => $db['database']['dbname'],
            'user' => $db['database']['user'],
            'password' => $db['database']['password'],
            'host' => $db['database']['host'],
            'driver' => $db['database']['driver'],
            'port' => $db['database']['port'],
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
