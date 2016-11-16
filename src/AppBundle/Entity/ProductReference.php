<?php

namespace AppBundle\Entity;

class ProductReference
{
    /**
     * @var string
     */
    private $reference;

    public function __construct(string $reference)
    {
        if (0 === preg_match('/^[0-9]{6}$/', $reference)) {
            throw new \DomainException('Invalid product reference format');
        }

        $this->reference = $reference;
    }

    public function __toString()
    {
        return $this->reference;
    }
}
