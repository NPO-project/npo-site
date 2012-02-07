<?php
namespace Npo\Model;

class Members
    extends ModelAbstract 
{
    const VALIDATE_INVALID_EMAIL = 0x01;
    const VALIDATE_INVALID_PASS = 0x02;

    public function tryLogin($email, $password)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT m
            FROM \Npo\Entity\Member m
            WHERE m.email = :email');

        $member = $query->getSingleResult();

        if (!$member)
            throw new \Zend_Validate_Exception('Invalid e-mail address');

        if ($member->password != sha1($password))
            throw new \Zend_Validate_Exception('Invalid password');

        return $member;
    }

    public function save($member)
    {
        $em = $this->getEntityManager();

        $em->persist($member);
        $em->flush();
    }
}
