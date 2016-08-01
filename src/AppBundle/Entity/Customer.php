<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use UMA\Psr7HmacBundle\Definition\ApiClientInterface;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer implements UserInterface, ApiClientInterface
{
    // A 18 byte sequence produces a 24 character long
    // base64 string with not padding (trailing equal signs)
    const BYTES_OF_ENTROPY = 18;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=32, unique=true)
     */
    private $username;

    /**
     * @var ShippingAddress
     *
     * @ORM\Embedded(class="ShippingAddress")
     */
    private $shippingAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=24, unique=true)
     */
    private $apiKey;

    /**
     * @var string
     *
     * @ORM\Column(name="shared_secret", type="string", length=24)
     */
    private $sharedSecret;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
        $this->shippingAddress = null;
        $this->apiKey = base64_encode(random_bytes(static::BYTES_OF_ENTROPY));
        $this->sharedSecret = base64_encode(random_bytes(static::BYTES_OF_ENTROPY));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param ShippingAddress $shippingAddress
     */
    public function updateShippingAddress(ShippingAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return ShippingAddress|null
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @return bool
     */
    public function hasShippingAddress()
    {
        return null !== $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getSharedSecret()
    {
        return $this->sharedSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_CUSTOMER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return;
    }
}

