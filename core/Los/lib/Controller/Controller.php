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

    /**
     * Kill the controller request.
     *
     * @param $message
     * @throws \Exception
     */
    protected function killRequest($message)
    {
        throw new \Exception($message);
    }

    /**
     * Json output.
     *
     * @param $output
     * @return JsonResponse
     */
    protected function jsonOutput($output)
    {
        return new JsonResponse($output);
    }

    /**
     * Standard response object.
     *
     * @param $output
     * @return Response
     */
    protected function output($output)
    {
        return new Response($output);
    }

    protected function isRouteCachedEnabled()
    {

    }

    protected function getCache()
    {

    }

    /**
     * Get entity manager.
     *
     * @return mixed
     */
    protected function getEntityManager()
    {
        return $this->container->get('entity.manager')->getEntityManager();
    }

    /**
     * Get entity repository.
     *
     * @param $entityName
     * @return mixed
     */
    protected function getEntityRepo($entityName)
    {
        return $this->container->get('entity.manager')->getEntityRepo($entityName);
    }

    /**
     * Get Entity Info.
     *
     * @return mixed
     */
    protected function getEntityInfo()
    {
        return $this->container->get('entity.info');
    }

    /**
     * Get configuration
     *
     * @return object
     */
    protected function getConfig()
    {
        return $this->container->get('config');
    }

    /**
     * Get Entity Info.
     *
     * @return mixed
     */
    protected function getRequest()
    {
        return $this->container->get('request')->getRequest();
    }

    /**
     * Get the API request content.
     *
     * @return mixed
     */
    protected function getRequestContent()
    {
        return $this->container->get('request')->getRequestContent();
    }

    /**
     * Get serializer.
     *
     * @return mixed
     */
    protected function getSerializer()
    {
        return $this->container->get('serializer')->getSerializer();
    }
}
