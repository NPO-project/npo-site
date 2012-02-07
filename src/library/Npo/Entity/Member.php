<?php
namespace Npo\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Column(name="email", type="text", length=100)
     */
    private $email;

    /**
     * @OneToOne(targetEntity="Registration")
     * @JoinColumn(name="registration_id", referencedColumnName="id")
     */
    private $registration;

    /**
     * @Column(name="password", type="text")
     */
    private $password;

    /**
     * @Column(name="forum_member_id", type="integer")
     */
    private $forumMemberId;

    /**
     * @Column(name="suspended", type="boolean")
     */
    private $suspended = false;

    /**
     * @OneToMany(targetEntity="Role", mappedBy="member", cascade={"persist"})
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection;
    }

    public function __get($field)
    {
        return $this->$field;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }
}
