<?php

namespace AppBundle\Security;

interface ApiUserInterface
{
    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @return string
     */
    public function getSharedSecret();
}
