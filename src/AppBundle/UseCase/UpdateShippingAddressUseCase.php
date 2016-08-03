<?php

namespace AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\ShippingAddress;
use Doctrine\ORM\EntityManager;

class UpdateShippingAddressUseCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Customer $customer
     * @param string   $newCountry
     * @param string   $newCity
     * @param string   $newPlace
     */
    public function execute(Customer $customer, $newCountry, $newCity, $newPlace)
    {
        $newShippingAddress = new ShippingAddress($newCountry, $newCity, $newPlace);

        $this->em->transactional(function () use ($customer, $newShippingAddress) {
            $customer->updateShippingAddress($newShippingAddress);
        });
    }
}
