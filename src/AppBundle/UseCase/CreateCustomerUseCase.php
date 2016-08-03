<?php

namespace AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\UseCase\Exception\UsernameTakenException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;

class CreateCustomerUseCase
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
     * @param string $newUsername
     * 
     * @throws UsernameTakenException
     */
    public function execute($newUsername)
    {
        try {
            $this->em->transactional(function () use ($newUsername) {
                $this->em->persist(new Customer($newUsername));
            });
        } catch (UniqueConstraintViolationException $e) {
            throw new UsernameTakenException($newUsername);
        }
    }
}
