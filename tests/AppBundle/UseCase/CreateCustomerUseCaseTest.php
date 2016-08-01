<?php

namespace Tests\AppBundle\UseCase;

use AppBundle\UseCase\CreateCustomerUseCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateCustomerUseCaseTest extends KernelTestCase
{
    /**
     * @var CreateCustomerUseCase
     */
    private $useCase;

    protected function setUp()
    {
        self::bootKernel();

        $this->useCase = self::$kernel->getContainer()
            ->get('use_case.create_customer');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
