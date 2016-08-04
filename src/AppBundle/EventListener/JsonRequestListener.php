<?php

namespace AppBundle\EventListener;

use JsonSchema\Validator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws BadJsonRequestException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if (null !== $schema = $this->container->get("json_schema.$route", ContainerInterface::NULL_ON_INVALID_REFERENCE)) {
            $validator = new Validator();
            $validator->check($data = json_decode($request->getContent()), $schema);

            if (!$validator->isValid()) {
                throw new BadJsonRequestException($data, $schema, $validator->getErrors());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => 'onKernelController'];
    }
}
