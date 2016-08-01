<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function add(Customer $customer)
    {
        $this->_em->persist($customer);
    }
}
