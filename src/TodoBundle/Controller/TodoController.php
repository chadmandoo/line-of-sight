<?php

namespace TodoBundle\Controller;

use Los\Core\Controller\Controller;

class TodoController extends Controller
{
    public function index($id)
    {
        return $this->output("hi");
    }
}