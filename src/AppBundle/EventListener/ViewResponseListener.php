<?php

declare(strict_types=1);

namespace AppBundle\EventListener;

use AppBundle\View\View;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ViewResponseListener implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 30],
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!($result instanceof View)) {
            $result = View::create($result);
        }

        $jsonString = $this->serializer->serialize($result->getData(), 'json', [
            'groups' => [
                'index',
            ],
        ]);

        $response = JsonResponse::fromJsonString($jsonString, $result->getStatusCode());

        $event->setResponse($response);
    }
}
