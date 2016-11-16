<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UMA\SchemaBundle\Annotation\JsonSchema;

class ApiController extends Controller
{
    /**
     * @Method("PUT")
     * @Route("/shipping-address", name="update_shipping_address")
     * @JsonSchema(filename="update_shipping_address.json")
     */
    public function updateShippingAddressAction(Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $this->get('use_case.update_shipping_address')
            ->execute($customer, $data['country'], $data['city'], $data['place']);

        return new JsonResponse($data);
    }

    /**
     * @Method("POST")
     * @Route("/orders", name="place_product_order")
     * @JsonSchema(filename="place_product_order.json")
     */
    public function placeProductOrderAction(Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->getUser();
        $data = json_decode($request->getContent(), true);

        try {
            $this->get('use_case.place_order')
                ->execute($customer, $data['product_reference'], $data['quantity']);
        } catch (\DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse($data);
    }

    /**
     * @Method("GET")
     * @Route("/orders", name="list_product_orders")
     */
    public function listProductOrdersAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        $orders = $this->get('repo.product_order')
            ->findByBuyer($customer);

        return new JsonResponse(
            $this->get('serializer')->normalize($orders)
        );
    }
}
