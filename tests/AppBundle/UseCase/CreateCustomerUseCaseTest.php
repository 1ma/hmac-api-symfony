<?php

namespace Tests\AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Username;
use AppBundle\Repository\CustomerRepository;
use AppBundle\UseCase\CreateCustomerUseCase;
use AppBundle\UseCase\Exception\UsernameTakenException;
use Tests\Util\DatabaseTestCase;

class CreateCustomerUseCaseTest extends DatabaseTestCase
{
    /**
     * @var CustomerRepository
     */
    private $repository;

    /**
     * @var CreateCustomerUseCase
     */
    private $useCase;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = self::$kernel->getContainer()
            ->get('repo.customer');

        $this->useCase = self::$kernel->getContainer()
            ->get('use_case.create_customer');
    }

    /**
     * @test
     */
    public function customerPersistence()
    {
        $this->useCase->execute(new Username('jdoe'));

        $jdoe = $this->repository
            ->findOneByUsername('jdoe');

        $this->assertInstanceOf(Customer::class, $jdoe);
    }

    /**
     * @test
     */
    public function usernameIsUniqueAmongCustomers()
    {
        $this->expectException(UsernameTakenException::class);
        $this->expectExceptionMessage('Username "jdoe" is already used by another customer');

        $this->useCase->execute(new Username('jdoe'));
        $this->useCase->execute(new Username('el_barto'));
        $this->useCase->execute(new Username('jdoe'));
    }
}
