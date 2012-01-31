<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;

/**
 * @Table(name="{DB_PREFIX}roles")
 * @Entity
 */
class Role
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Member")
     */
    private $member;

    /**
     * @Id
     * @Column(name="role", type="text", length=50)
     */
    private $role;

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
