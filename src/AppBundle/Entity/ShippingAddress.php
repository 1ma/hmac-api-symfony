<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class ShippingAddress
{
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=32, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=128, nullable=true)
     */
    private $place;

    /**
     * @param string $country
     * @param string $city
     * @param string $place
     */
    public function __construct(string $country, string $city, string $place)
    {
        $this->country = $country;
        $this->city = $city;
        $this->place = $place;
    }

    public function __toString()
    {
        return null === $this->country || null === $this->city || null === $this->place ?
            '(unknown)' : sprintf('%s, %s, %s', $this->country, $this->city, $this->place);
    }
}
