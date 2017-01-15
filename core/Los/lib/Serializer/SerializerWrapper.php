<?php

namespace Los\Core\Serializer;

use Los\Core\Entity\Entity;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Class SerializerWrapper
 * @package Los\Core\Serializer
 */
class SerializerWrapper
{
    private $serializer;

    /**
     * SerializerWrapper constructor.
     */
    public function __construct()
    {
        $this->serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Serialize object
     *
     * @param object $entities
     * @return string
     */
    public function serialize($entities)
    {
        $output = '';

        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $output .= $this->serializeSingle($entity);
            }
        } else {
            $output .= $this->serializeSingle($entities);
        }

        return $output;
    }

    /**
     * Serialize a single object.
     *
     * @param $entity
     * @return mixed
     */
    private function serializeSingle($entity)
    {
        return $this->serializer->serialize($entity, 'json');
    }
}