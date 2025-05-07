<?php

declare(strict_types=1);

namespace App\Service\Validation\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SpecialCharacterValidator implements ValidatorInterface
{
    private string $pattern = '/[^a-zA-Z0-9@.]/';

    public function validate(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $key => $value) {
            if (!is_string($value)) {
                throw new BadRequestHttpException("Invalid format in field: $key.");
            }

            if (preg_match($this->pattern, $value)) {
                throw new BadRequestHttpException("Invalid characters in field: $key.");
            }
        }
    }
}