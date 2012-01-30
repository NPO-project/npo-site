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
 * @Table(name="{DB_WORLDPREFIX}certificates")
 * @Entity
 */
class Certificate
    extends EntityAbstract
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @Id
     * @Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @ManyToOne(targetEntity="Role")
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
