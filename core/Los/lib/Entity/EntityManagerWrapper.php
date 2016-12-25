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
    const CONFIG_PATH   = __DIR__.'/../../../../app/config/config.json';
    const SRC_PATH      = __DIR__."/../../../../src";

    private $entityManager;

    /**
     * EntityManagerWrapper constructor.
     */
    public function __construct()
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

        $config = Setup::createAnnotationMetadataConfiguration(array(self::SRC_PATH), true);

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
}