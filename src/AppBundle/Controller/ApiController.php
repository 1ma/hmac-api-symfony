<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @Method("PUT")
     * @Route("/shipping-address", name="update_shipping_address")
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
    }

    /**
     * @Method("GET")
     * @Route("/orders/{id}", name="inspect_product_order")
     */
    public function inspectProductOrderAction($id)
    {
    }
}
