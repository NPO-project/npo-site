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
    extends EntityAbstract
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
     * @OneToMany(targetEntity="Player", mappedBy="tribe")
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
