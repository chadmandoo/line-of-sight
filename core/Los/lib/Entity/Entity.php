<?php

namespace Los\Core\Entity;

/**
 * Class Entity
 * @package Los\Core
 */
class Entity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="datetime") **/
    protected $createdDate;
    /** @Column(type="datetime") **/
    protected $updatedDate;

    /**
     * Entity constructor.
     * @param array $options
     */
    public function __construct($options = array())
    {
        if (isset($options)) {
            $this->setup($options);
        }
    }

    /**
     * Magic method call.
     *
     * @param string $name
     * @param mixed  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $propertyName = lcfirst(substr($name, 3));

        if ('set' === substr($name, 0, 3)) {
            $this->setProperty($propertyName, $arguments);
        } elseif ('get' === substr($name, 0, 3)) {
            return $this->getProperty($propertyName);
        }
    }

    /**
     * Dynamically set property.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setProperty($name, $value)
    {
        $this->$name = current($value);
    }

    /**
     * Get property.
     *
     * @param string $name
     * @return mixed
     */
    public function getProperty($name)
    {
        return $this->$name;
    }

    /**
     * Get all properties.
     *
     * @return array
     */
    public function getAllProperties()
    {
        return get_object_vars($this);
    }

    private function setup($options)
    {
        // @TODO generic setup option.
    }
}
