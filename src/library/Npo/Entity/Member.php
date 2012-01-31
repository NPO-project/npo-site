<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\SequenceGenerator;

/**
 * @Table(name="{DB_PREFIX}members")
 * @Entity
 */
class Member
{
    /**
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @Column(name="id", type="integer")
     * @SequenceGenerator(sequenceName="{DB_PREFIX}members_id_seq")
     */
    private $id;

    /**
     * @Column(name="name", type="text", length=50)
     */
    private $name;

    /**
     * @OneToMany(targetEntity="Registration", mappedBy="member")
     */
    private $registrations;

    /**
     * @Column(name="forum_member_id", type="integer")
     */
    private $forumMemberId;

    /**
     * @Column(name="suspended", type="boolean")
     */
    private $suspended;

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
