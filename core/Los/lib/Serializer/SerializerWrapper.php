<?php

namespace Los\Core\Serializer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
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
        $this->serializer = new Serializer(new ObjectNormalizer(), array(new XmlEncoder(), new JsonEncoder()));
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
}