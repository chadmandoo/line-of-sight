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
     * Magic method call.
     *
     * @param string $name
     * @param mixed  $arguments
     * @return void|mixed
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param mixed $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @param mixed $updatedDate
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }
}
