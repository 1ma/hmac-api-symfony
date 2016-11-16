<?php

namespace Tests\AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\ShippingAddress;
use AppBundle\Entity\Username;
use AppBundle\Repository\CustomerRepository;
use AppBundle\UseCase\UpdateShippingAddressUseCase;
use Tests\Util\DatabaseTestCase;

class UpdateShippingAddressUseCaseTest extends DatabaseTestCase
{
    /**
     * @var CustomerRepository
     */
    private $repository;

    /**
     * @var UpdateShippingAddressUseCase
     */
    private $useCase;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = self::$kernel->getContainer()
            ->get('repo.customer');

        $this->useCase = self::$kernel->getContainer()
            ->get('use_case.update_shipping_address');
    }

    /**
     * @test
     */
    public function correctShippingAddressUpdate()
    {
        $this->em->persist($elBarto = new Customer(new Username('el_barto')));
        $this->em->flush();

        $this->useCase->execute($elBarto, new ShippingAddress('US', 'Springfield', '742 Evergreen Terrace'));

        $elBarto = $this->repository
            ->findOneByUsername('el_barto');

        $this->assertSame('US, Springfield, 742 Evergreen Terrace', (string) $elBarto->getShippingAddress());
    }
}
