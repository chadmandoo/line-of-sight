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

    /**
     * Serialize object
     *
     * @param $entities
     * @param string $type
     * @return Response
     */
    protected function serialize($entities, $type = 'json')
    {
        $output = '';

        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $output .= $this->serializeSingle($entity, $type);
            }
        } else {
            $output .= $this->serializeSingle($entities, $type);
        }

        return $this->output($output);
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
     * Get serializer.
     *
     * @return mixed
     */
    protected function getSerializer()
    {
        return $this->container->get('serializer')->getSerializer();
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
     * Get Entity Info.
     *
     * @return mixed
     */
    protected function getRequest()
    {
        return $this->container->get('request')->getRequest();
    }

    /**
     * Serialize a single object.
     *
     * @param $entity
     * @param $type
     * @return mixed
     */
    private function serializeSingle($entity, $type)
    {
        return $this->getSerializer()->serialize($entity, $type);
    }
}