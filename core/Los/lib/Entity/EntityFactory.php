<?php

namespace Los\Core\Entity;

/**
 * Class EntityFactory
 * @package Los\Core\Entity
 */
class EntityFactory
{
    /**
     * Create an entity
     *
     * @param string     $type
     * @param EntityInfo $entityInfo
     * @param array      $options
     *
     * @return mixed
     */
    public static function createEntity($type, EntityInfo $entityInfo, $options = array())
    {
        if (strstr($type, '\\')) {
            $entity = new $type($options);
        } else {
            $entityNamespace = $entityInfo->getEntityInfoByNameSpace($type);

            if ($entityNamespace) {
                $entity = new $entityNamespace($options, 'namespace');
            } else {
                //@TODO implement our own exception letting the user know the issue.
            }
        }

        return $entity;
    }
}
