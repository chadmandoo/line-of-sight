<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;
use Los\Core\Entity\EntityRepository;
use TodoBundle\Entity\Todo;

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

    /**
     * Create a ToDo item.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $created = false;
        $content = $this->getRequestContent();

        if (!empty($content['content'])) {
            $todoEntity = new Todo();
            $todoEntity->setTitle($content['content']['title']);
            $todoEntity->setDescription($content['content']['description']);

            EntityRepository::saveEntity($this->getEntityManager(), $todoEntity);
            $created = true;
        }

        return $this->jsonOutput($created);
    }

    /**
     * Read a single ToDo.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read($id = null)
    {
        $entity = $this->getEntityRepo('todo')
            ->findById($id);

        return ($entity) ? $this->jsonOutput(current($entity)->getAllProperties()) : $this->jsonOutput(array('error' => 'No Entity Found'));
    }

    /**
     * Updated Entity by ID
     *
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id = null)
    {
        $updated = false;
        $content = $this->getRequestContent();

        if (!empty($content['content']) && $id) {
            $todoEntity = $this->getEntityRepo('todo')->findById($id);
            $todoEntity = current($todoEntity);
            $todoEntity->setTitle($content['content']['title']);
            $todoEntity->setDescription($content['content']['description']);

            EntityRepository::saveEntity($this->getEntityManager(), $todoEntity);
            $updated = true;
        }

        return $this->jsonOutput($updated);
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

    /**
     * Generate some ToDos.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generate()
    {
        for ($i = 0; $i < 10000; $i++) {
            $todoEntity = new Todo();
            $todoEntity->setTitle('Todo Number ' . $i);
            $todoEntity->setDescription('Here is a description for Todo '. $i);
            EntityRepository::saveEntity($this->getEntityManager(), $todoEntity);
        }

        return $this->jsonOutput('complete');
    }
}