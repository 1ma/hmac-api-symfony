<?php

namespace AppBundle\Security;

use AppBundle\Entity\Customer;
use AppBundle\Repository\CustomerRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomerProvider implements UserProviderInterface
{
    /**
     * @var CustomerRepository
     */
    private $repository;

    /**
     * @param CustomerRepository $repository
     */
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $customer = $this->repository
            ->findOneByApiKey($username);

        if (null === $customer) {
            throw new UsernameNotFoundException();
        }

        return $customer;
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the api key is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless.
        throw new UnsupportedUserException();
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return Customer::class === $class;
    }
}
