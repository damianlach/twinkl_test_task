<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Provider\ResponseProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiKeyMiddleware implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $apiKey = $request->query->get('api_key');

        if (!$apiKey || $apiKey !== $_ENV['API_KEY']) {
            $event->setResponse(new JsonResponse(['error' => 'Unauthorized, wrong API key'], Response::HTTP_UNAUTHORIZED));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10],
        ];
    }
}