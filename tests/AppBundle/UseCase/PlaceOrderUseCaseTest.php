<?php

namespace Tests\AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\ProductReference;
use AppBundle\Entity\ShippingAddress;
use AppBundle\Entity\Username;
use AppBundle\Repository\ProductOrderRepository;
use AppBundle\UseCase\PlaceOrderUseCase;
use Tests\Util\DatabaseTestCase;

class PlaceOrderUseCaseTest extends DatabaseTestCase
{
    /**
     * @var ProductOrderRepository
     */
    private $repository;

    /**
     * @var PlaceOrderUseCase
     */
    private $useCase;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = self::$kernel->getContainer()
            ->get('repo.product_order');

        $this->useCase = self::$kernel->getContainer()
            ->get('use_case.place_order');
    }

    /**
     * @test
     */
    public function placeSomeOrders()
    {
        $this->em->persist($elBarto = new Customer(new Username('el_barto')));
        $elBarto->updateShippingAddress(new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));
        $this->em->flush();

        $this->useCase->execute($elBarto, new ProductReference('000000'), 1);
        $this->useCase->execute($elBarto, new ProductReference('012345'), 5);
        $this->useCase->execute($elBarto, new ProductReference('456789'), 3);

        $orders = $this->repository->findByBuyer($elBarto);
        $this->assertCount(3, $orders);
    }
}
