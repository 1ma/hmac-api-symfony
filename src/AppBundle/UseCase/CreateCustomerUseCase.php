<?php

namespace AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Username;
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
     * @param string $desiredUsername
     * 
     * @throws UsernameTakenException
     */
    public function execute(string $desiredUsername)
    {
        try {
            $this->em->transactional(function () use ($desiredUsername) {
                $this->em->persist(new Customer(new Username($desiredUsername)));
            });
        } catch (UniqueConstraintViolationException $e) {
            throw new UsernameTakenException($desiredUsername, $e);
        }
    }
}
