<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;
use Los\Core\Entity\EntityBuilder;
use Los\Core\Entity\EntityFactory;
use TodoBundle\Entity\Todo;

/**
 * Class TodoController
 * @package TodoBundle\Controller
 */
class TodoController extends Controller
{
    public function index()
    {
        $todo = EntityFactory::createEntity('todo', $this->getEntityInfo());

        return $this->output('hi');
    }

    public function create($id)
    {
        //return $this->serialize($entities);
    }

    public function read($id)
    {
        $entities = $this->getEntityManager()->getRepository('TodoBundle\Entity\Todo')
            ->findById($id);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}