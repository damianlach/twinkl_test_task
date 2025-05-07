<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\Validation\Middleware\IpBlacklistValidator;
use App\Service\Validation\Middleware\SpecialCharacterValidator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;

class RegistrationValidationMiddleware implements EventSubscriberInterface
{
    public function __construct(
        private IpBlacklistValidator $ipValidator,
        private SpecialCharacterValidator $characterValidator
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // IP Block Check
        try {
            $this->ipValidator->validate($request);
        } catch (\Exception $e) {
            $event->setResponse(new JsonResponse(['error' => $e->getMessage()], 403));
            return;
        }

        // Checking for special characters
        try {
            $this->characterValidator->validate($request);
        } catch (\Exception $e) {
            $event->setResponse(new JsonResponse(['error' => $e->getMessage()], 400));
            return;
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10],
        ];
    }
}
