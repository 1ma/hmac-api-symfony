<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

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

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return;
        }
    }

    /**
     * @param string $apiKey
     *
     * @return Customer|null
     */
    public function findOneByApiKey(string $apiKey)
    {
        $query = $this->_em->createQuery('
            SELECT c
              FROM AppBundle:Customer c
             WHERE c.apiKey = :apiKey
        ')->setParameter('apiKey', $apiKey);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return;
        }
    }

    /**
     * @return Customer[]
     */
    public function findAll()
    {
        return parent::findAll();
    }
}
