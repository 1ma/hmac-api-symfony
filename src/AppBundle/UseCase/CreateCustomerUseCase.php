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
     * @param Username $desiredUsername
     * 
     * @throws UsernameTakenException
     */
    public function execute(Username $desiredUsername)
    {
        try {
            $this->em->transactional(function () use ($desiredUsername) {
                $this->em->persist(new Customer($desiredUsername));
            });
        } catch (UniqueConstraintViolationException $e) {
            throw new UsernameTakenException($desiredUsername, $e);
        }
    }
}
