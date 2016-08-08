<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductOrderRepository")
 * @ORM\Table(name="product_orders")
 */
class ProductOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $buyer;

    /**
     * @var string
     *
     * @ORM\Column(name="product_reference", type="string")
     */
    private $productReference;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Dollar
     *
     * @ORM\Embedded(class="Dollar")
     */
    private $price;

    /**
     * @var Dollar
     *
     * @ORM\Embedded(class="Dollar")
     */
    private $fees;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivery_date", type="date")
     */
    private $deliveryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="order_date", type="date")
     */
    private $orderDate;

    /**
     * @param Customer  $buyer
     * @param string    $productReference
     * @param int       $quantity
     * @param Dollar    $price
     * @param Dollar    $fees
     * @param \DateTime $deliveryDate
     *
     * @throws \DomainException
     */
    public function __construct(Customer $buyer, string $productReference, int $quantity, Dollar $price, Dollar $fees, \DateTime $deliveryDate)
    {
        if (0 >= $quantity) {
            throw new \DomainException('wai wat');
        }

        if ((new \DateTime('today')) > $deliveryDate) {
            throw new \DomainException('ehm no.');
        }

        if (!$buyer->hasShippingAddress()) {
            throw new \DomainException('so?');
        }

        $this->buyer = $buyer;
        $this->productReference = $productReference;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->fees = $fees;
        $this->deliveryDate = $deliveryDate;
        $this->orderDate = new \DateTime('today');
    }

    /**
     * @return string
     */
    public function getProductReference()
    {
        return $this->productReference;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Dollar
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return Dollar
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }
}
