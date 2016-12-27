<?php

namespace Los\Core\Entity;

/**
 * Class EntityInfo
 * @package Los\Core\Entity
 */
class EntityInfo
{
    private $entityInfo;

    /**
     * EntityInfo constructor.
     * @param array $entityInfo
     */
    public function __construct($entityInfo)
    {
        $this->entityInfo = $entityInfo;
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

    /**
     * Find entity by namespace;
     *
     * @param string $name
     * @return mixed|string
     */
    public function getEntityInfoByNameSpace($name)
    {
        $namespace = '';

        if (array_key_exists($name, $this->entityInfo)) {
            $namespace = $this->entityInfo[$name]['namespace'];
        }

        return $namespace;
    }

    /**
     * Get information ab out an entity.
     *
     * @param string $name
     * @param string $type
     *
     * @return string
     */
    public function queryEntityInfo($name, $type = 'all')
    {
        $info = '';
        if (array_key_exists($name, $this->entityInfo)) {
            if ($type == 'all') {
                $info = $this->entityInfo[$name];
            } else {
                if (isset($this->entityInfo[$name][$type])) {
                    $info = $this->entityInfo[$name][$type];
                }
            }
        }

        return $info;
    }
}