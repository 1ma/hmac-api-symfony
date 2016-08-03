<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Method("PUT")
     * @Route("/shipping_address", name="update_shipping_address")
     */
    public function updateShippingAddressAction()
    {
    }

    /**
     * @Method("POST")
     * @Route("/orders", name="place_product_order")
     */
    public function placeProductOrderAction()
    {
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
