<?php

namespace AppBundle\UseCase\Exception;

class UsernameTakenException extends \RuntimeException
{
    public function __construct($username)
    {
        parent::__construct(
            sprintf('Username "%s" is already used by another customer', $username)
        );
    }
}
