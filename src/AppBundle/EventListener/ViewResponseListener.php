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
     *
     * @throws \Exception
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!($result instanceof View)) {
            throw new \Exception(sprintf(
                'Controller result must be instance of %s, %s given',
                View::class,
                get_class($result)
            ));
        }

        $responseData = [
            'meta' => [
                'state' => $result->getState(),
            ],
            'data' => $result->getData(),
        ];

        $jsonString = $this->serializer->serialize($responseData, 'json', [
            'groups' => $result->getGroups(),
        ]);

        $response = JsonResponse::fromJsonString($jsonString, $result->getStatusCode());

        $event->setResponse($response);
    }
}
