<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Id;

/**
 * @Table(name="{DB_PREFIX}players")
 * @Entity
 */
class Player
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @Column(name="name", type="text", length=50)
     */
    protected $name;

    /**
     * @ManyToOne(targetEntity="Tribe")
     */
    protected $tribe;

    /**
     * @OneToMany(targetEntity="Certificate", mappedBy="playerId")
     */
    protected $certificates;

    /**
     * @Column(name="rank", type="integer")
     */
    protected $rank;

    /**
     * @Column(name="points", type="integer")
     */
    protected $points;

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
