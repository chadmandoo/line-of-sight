<?php
namespace Los\Core\Entity;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityBuilder
 * @package Core\Entity
 */
class EntityBuilder
{
    /**
     * Get entity by ID.
     *
     * @param string  $type
     * @param integer $id
     * @return mixed
     */
    public static function findById(EntityManagerInterface $manager, $type, $id)
    {
        $entities = $manager->getRepository($type)
            ->findById($id);

        return current($entities);
    }

    /**
     * Find all of entities.
     *
     * @param string $type
     * @return mixed
     */
    public static function findAll($type)
    {
        $type = self::getNamespace($type);
        $manager = DatabaseHandler::getManager();
        $entities = $manager->getRepository($type)
            ->findAll();

        return $entities;
    }

    /**
     * Find all by options.
     *
     * @param string $type
     * @param array  $options
     * @return mixed
     */
    public static function findBy($type, $options)
    {
        $type = self::getNamespace($type);
        $manager = DatabaseHandler::getManager();
        $entities = $manager->getRepository($type)
            ->findBy($options);

        return $entities;
    }

    /**
     * Find by options.
     *
     * @param string $type
     * @param array  $options
     * @return mixed
     */
    public static function findOneBy($type, $options)
    {
        $type = self::getNamespace($type);
        $manager = DatabaseHandler::getManager();
        $entities = $manager->getRepository($type)
            ->findOneBy($options);

        return $entities;
    }

    /**
     * Find with join table.
     *
     * @param string $type
     * @param array  $options
     * @return mixed
     */
    public static function findByJoinTable($type, $options)
    {
        $type = self::getNamespace($type);
        $manager = DatabaseHandler::getManager();

        $query = $manager->getRepository($type)
            ->createQueryBuilder('u');

        if (isset($options['where'])) {
            foreach ($options['where'] as $key => $where) {
                $query->innerJoin('u.'.$key, 'g');
                foreach ($where as $k => $w) {
                    if ($k == 0) {
                        $query->where('g.id = :param_'.$w)
                            ->setParameter('param_'.$w, $w);
                    } else {
                        $query->orWhere('g.id = :param_'.$w)
                            ->setParameter('param_'.$w, $w);
                    }
                }
            }
        }

        $entities = $query->getQuery()
            ->getResult();

        return $entities;
    }

    /**
     * Find something that does not have a value.
     *
     * @param string $type
     * @param array  $options
     * @return mixed
     */
    public static function findNotBy($type, $options)
    {
        $type = self::getNamespace($type);
        $manager = DatabaseHandler::getManager();

        $query = $manager->getRepository($type)
            ->createQueryBuilder('a');
        $query->where($query->expr()->not($query->expr()->eq('a.'.$options['item'], ':value')))
            ->setParameter('value', $options['value']);

        return $query->getQuery()
            ->getResult();
    }

    /**
     * Save entity.
     *
     * @param EntityManagerInterface $manager
     * @param Entity                 $entity
     */
    public static function saveEntity(EntityManagerInterface $manager, Entity &$entity)
    {
        $entity->setUpdatedDate(new \DateTime("now"));

        if (!$entity->getCreatedDate()) {
            $entity->setCreatedDate(new \DateTime("now"));
            $manager->persist($entity);
        } else {
            $manager->merge($entity);
        }

        $manager->flush();
    }

    /**
     * Remove entity.
     *
     * @param object $entity
     * @param object $entityOld
     * @param array  $additionalInfo
     */
    public static function removeEntity($entity, $entityOld = null, $additionalInfo = array())
    {
        $manager = DatabaseHandler::getManager();
        $manager->remove($entity);

        $manager->flush();
    }

    /**
     * Get namespace.
     *
     * @param string $name
     * @return mixed
     */
    public static function getNamespace($name)
    {
        $namespace = $name;

        if (!substr_count($name, "Entity")) {
            $entityInfo = DlEntityInfoHandler::getEntityInfo();
            $namespace = $entityInfo->getEntityInfo($name, 'namespace');
        }

        return $namespace;
    }
}
