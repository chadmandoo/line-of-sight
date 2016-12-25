<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;
use TodoBundle\Entity\Todo;

class TodoController extends Controller
{
    public function index($id)
    {
        return $this->output('');
    }
}