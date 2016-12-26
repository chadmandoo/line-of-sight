<?php

namespace TodoBundle\Entity;

use Los\Core\Entity\Entity;

/**
 * Class InvoiceStatus
 * @package TodoBundle\Entity
 * @Entity @Table(name="todo")
 */
class Todo extends Entity
{
    /** @Column(type="string") **/
    protected $title;
    /** @Column(type="text", nullable=true) * */
    protected $description;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}