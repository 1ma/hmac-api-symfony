<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Dollar;
use AppBundle\Entity\ProductOrder;
use AppBundle\Entity\ShippingAddress;

class ProductOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function correctProductOrderPlacement()
    {
        $buyer = new Customer('hjsimpson');
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, '777-456', 1, new Dollar(7515), new Dollar(150), new \DateTime('tomorrow'));
    }

    /**
     * @test
     */
    public function productBuyerMustHaveAShippingAddress()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer('jdoe');

        new ProductOrder($buyer, '738-285', 1, new Dollar(1499), new Dollar(0), new \DateTime('tomorrow'));
    }

    /**
     * @test
     */
    public function productDeliveryDateMustBeTodayOrInTheFuture()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer('hjsimpson');
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, '738-285', 2, new Dollar(2998), new Dollar(0), new \DateTime('yesterday'));
    }

    /**
     * @test
     */
    public function productOrderQuantityIsAtLeastOne()
    {
        $this->expectException(\DomainException::class);

        $buyer = new Customer('hjsimpson');
        $buyer->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        new ProductOrder($buyer, '738-285', 0, new Dollar(1499), new Dollar(0), new \DateTime('tomorrow'));
    }
}
