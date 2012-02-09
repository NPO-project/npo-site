<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\SequenceGenerator;

/**
 * @Table(name="{DB_PREFIX}tribes")
 * @Entity
 */
class Tribe
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @Column(name="name", type="text", length=50)
     */
    private $name;

    /**
     * @Column(name="tag", type="text", length=50)
     */
    private $tag;

    /**
     * @Column(name="points", type="integer")
     */
    private $points;

    /**
     * @Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @OneToMany(targetEntity="Player", mappedBy="tribe", cascade="{ALL}", fetch="LAZY")
     */
    private $players;

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
