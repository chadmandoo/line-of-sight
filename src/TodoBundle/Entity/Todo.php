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
}