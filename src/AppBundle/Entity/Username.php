<?php

namespace AppBundle\Entity;

class Username
{
    /**
     * @var string
     */
    private $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        if (mb_strlen($username) > 8) {
            throw new \DomainException('username exceeds maximum length');
        }

        $this->username = $username;
    }

    public function __toString()
    {
        return $this->username;
    }
}
