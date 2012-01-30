<?php
namespace Npo\Model;

class Registrations
    extends ModelAbstract 
{
    public function save($registration)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();

        try
        {
            $em->persist($registration);
            $em->flush();
            $em->getConnection()->commit();
        }
        catch (Exception $e)
        {
            $em->getConnection()->rollback();
            $em->close();

            throw $e;
        }
    }
}
