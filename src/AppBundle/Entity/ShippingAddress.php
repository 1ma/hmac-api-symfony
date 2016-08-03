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
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @param string $country
     * @param string $city
     * @param string $place
     */
    public function __construct($country, $city, $place)
    {
        $this->country = $country;
        $this->city = $city;
        $this->place = $place;
    }

    public function __toString()
    {
        return sprintf('%s, %s, %s', $this->country, $this->city, $this->place);
    }
}
