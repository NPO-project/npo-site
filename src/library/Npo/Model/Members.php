<?php
namespace Npo\Model;

class Members
    extends ModelAbstract 
{
    public function tryLogin($email, $password)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT m
            FROM \Npo\Entity\Member m
            LEFT JOIN m.roles f
            WHERE m.email = :email');

        $query->setParameter('email', $email);

        try 
        {
            $member = $query->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            throw new \Zend_Validate_Exception('Invalid e-mail address');
        }

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

    public function get($id)
    {
        $em = $this->getEntityManager();

        return $em->find('\Npo\Entity\Member', $id);
    }
}
