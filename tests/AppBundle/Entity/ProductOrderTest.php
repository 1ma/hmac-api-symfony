<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Dollar;
use AppBundle\Entity\ProductOrder;
use AppBundle\Entity\ProductReference;
use AppBundle\Entity\ShippingAddress;
use AppBundle\Entity\Username;

class ProductOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function correctProductOrderPlacement()
    {
        $buyer = new Customer(new Username('el_barto'));
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, new ProductReference('777456'), 1, new Dollar(7515), new Dollar(150), new \DateTime('tomorrow'));
    }

    /**
     * @test
     */
    public function productBuyerMustHaveAShippingAddress()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer(new Username('jdoe'));

        new ProductOrder($buyer, new ProductReference('738285'), 1, new Dollar(1499), new Dollar(0), new \DateTime('tomorrow'));
    }

    /**
     * @test
     */
    public function productDeliveryDateMustBeTodayOrInTheFuture()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer(new Username('el_barto'));
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, new ProductReference('738285'), 2, new Dollar(2998), new Dollar(0), new \DateTime('yesterday'));
    }

    /**
     * @test
     */
    public function productOrderQuantityIsAtLeastOne()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer(new Username('el_barto'));
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, new ProductReference('738285'), 0, new Dollar(1499), new Dollar(0), new \DateTime('tomorrow'));
    }
}
