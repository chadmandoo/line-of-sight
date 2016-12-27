<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;
use Los\Core\Entity\EntityBuilder;
use Los\Core\Entity\EntityFactory;

/**
 * Class TodoController
 * @package TodoBundle\Controller
 */
class TodoController extends Controller
{
    public function test()
    {
        return $this->output('hi');
    }

    public function detail($id)
    {
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