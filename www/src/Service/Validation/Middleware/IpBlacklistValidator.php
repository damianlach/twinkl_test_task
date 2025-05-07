<?php

declare(strict_types=1);

namespace App\Service\Validation\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IpBlacklistValidator implements ValidatorInterface
{
    private array $blacklistedIps = [
        '192.168.1.1',
        '172.21.0.122'
    ];

    public function validate(Request $request): void
    {
        $clientIp = $request->getClientIp();

        if (in_array($clientIp, $this->blacklistedIps, true)) {
            throw new AccessDeniedHttpException('Your IP is blocked.');
        }
    }
}