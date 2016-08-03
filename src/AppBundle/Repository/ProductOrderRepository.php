<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use AppBundle\Entity\ProductOrder;
use Doctrine\ORM\EntityRepository;

class ProductOrderRepository extends EntityRepository
{
    /**
     * @param Customer $buyer
     *
     * @return ProductOrder[]
     */
    public function findByBuyer(Customer $buyer)
    {
        $query = $this->_em->createQuery('
            SELECT po
              FROM AppBundle:ProductOrder po
             WHERE po.buyer = :buyer
        ')->setParameter('buyer', $buyer);

        return $query->getResult();
    }
}
