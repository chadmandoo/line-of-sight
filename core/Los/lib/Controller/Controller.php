<?php

namespace Los\Core\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 * @package Los\Core\Controller
 */
class Controller
{
    protected function jsonOutput($output)
    {
        return new JsonResponse();
    }

    protected function serializedOutput($output)
    {
        return new Response($output);
    }

    protected function output($output)
    {
        return new Response($output);
    }
}