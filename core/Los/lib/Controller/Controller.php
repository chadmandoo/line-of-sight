<?php

namespace Los\Core\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 * @package Los\Core\Controller
 */
class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function jsonOutput($output)
    {
        return new JsonResponse($output);
    }

    protected function output($output)
    {
        return new Response($output);
    }

    protected function serializer($object, $type = 'json')
    {
        $output = $this->getSerializer()->serialize($object, $type);

        return $this->output($output);
    }

    protected function getEntityManager()
    {
        return $this->container->get('entity.manager')->getEntityManager();
    }

    protected function getSerializer()
    {
        return $this->container->get('serializer');
    }
}