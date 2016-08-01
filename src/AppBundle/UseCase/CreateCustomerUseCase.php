<?php

namespace AppBundle\UseCase;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityManager;

class CreateCustomerUseCase
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @param EntityManager      $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param string $newUsername
     */
    public function execute($newUsername)
    {
        $this->manager->transactional(function () use ($newUsername) {
            $this->manager->persist(new Customer($newUsername));
        });
    }
}
