<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Dollar
{
    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    public function __construct(int $amount)
    {
        if (0 > $amount) {
            throw new \DomainException('get outta here');
        }

        $this->amount = $amount;
    }

    public function __toString()
    {
        return '$'.number_format($this->amount/100, 2, '.', ',');
    }
}

