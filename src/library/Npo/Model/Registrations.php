<?php
namespace Npo\Model;

class Registrations
    extends ModelAbstract 
{
    public function save($registration)
    {
        $em = $this->getEntityManager();

        $em->persist($registration);
        $em->flush();
    }

    public function getOpenRegistrations()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT r
            FROM \Npo\Entity\Registration r
            WHERE r.status = :status
            ORDER BY r.date DESC');
        $query->setParameter('status', 'open');

        return $query->getResult();
    }

    public function get($id)
    {
        $em = $this->getEntityManager();

        return $em->find('\Npo\Entity\Registration', $id);
    }
}
