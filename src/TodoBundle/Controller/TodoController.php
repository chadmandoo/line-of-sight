<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;
use Los\Core\Entity\EntityRepository;

/**
 * Class TodoController
 * @package TodoBundle\Controller
 */
class TodoController extends Controller
{
    /**
     * Returns all ToDo entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $entities = $this->getEntityRepo('todo')
            ->findAll();

        foreach ($entities as $entity) {
            $output[] = $entity->getAllProperties();
        }

        return $this->jsonOutput($output);
    }


    public function create()
    {

    }

    /**
     * Read a single todo.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read($id = null)
    {
        $entity = $this->getEntityRepo('todo')
            ->findById($id);
        
        return ($entity) ? $this->serialize($entity) : $this->jsonOutput(array('error' => 'No Entity Found'));
    }

    public function update()
    {

    }

    /**
     * Delete an entity.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete($id = null)
    {
        $removed = false;

        $entity = $this->getEntityRepo('todo')
            ->findById($id);

        if ($entity) {
            EntityRepository::removeEntity($this->getEntityManager(), current($entity));
            $removed = true;
        }

        return $this->jsonOutput(array('removed' => $removed));
    }
}