<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\SequenceGenerator;

/**
 * @Table(name="{DB_PREFIX}Registrations")
 * @Entity
 */
class Registration
{
    public function __construct()
    {
        $this->date = new \DateTime;
    }

    /**
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @Column(name="id", type="integer")
     * @SequenceGenerator(sequenceName="{DB_PREFIX}members_id_seq")
     */
    private $id;

    /**
     * @Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @Column(name="status", type="text")
     */
    private $status = 'open';

    /**
     * @Column(name="player_name", type="text", length=50)
     */
    private $playerName;

    /**
     * @Column(name="name", type="text", length=100)
     */
    private $name;

    /**
     * @Column(name="email", type="text", length=100)
     */
    private $email;

    /**
     * @Column(name="function", type="text")
     */
    private $function;

    /**
     * @Column(name="letter", type="text", length=1000)
     */
    private $letter;

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
