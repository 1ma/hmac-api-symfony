<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\ProductOrder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductOrderNormalizer implements NormalizerInterface
{
    /**
     * @param ProductOrder $object
     *
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'product_reference' => $object->getProductReference(),
            'quantity' => $object->getQuantity(),
            'price' => (string) $object->getPrice(),
            'fees' => (string) $object->getFees(),
            'order_date' => $object->getOrderDate()->format(\DateTime::ISO8601),
            'delivery_date' => $object->getDeliveryDate()->format(\DateTime::ISO8601),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ProductOrder;
    }
}
