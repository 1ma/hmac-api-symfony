<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    /**
     * @param string $username
     *
     * @return Customer|null
     */
    public function findOneByUsername(string $username)
    {
        $query = $this->_em->createQuery('
            SELECT c
              FROM AppBundle:Customer c
             WHERE c.username = :username
        ')->setParameter('username', $username);

        return $query->getSingleResult();
    }

    /**
     * @return Customer[]
     */
    public function findAll()
    {
        return parent::findAll();
    }
}
