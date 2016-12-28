<?php
namespace Los\Core\Entity;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityRepository
 * @package Core\Entity
 */
class EntityRepository
{
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
     * Remove entity
     *
     * @param EntityManagerInterface $manager
     * @param Entity                 $entity
     */
    public static function removeEntity(EntityManagerInterface $manager, Entity $entity)
    {
        $manager->remove($entity);
        $manager->flush();
    }
}
