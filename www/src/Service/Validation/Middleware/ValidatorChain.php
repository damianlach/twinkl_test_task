<?php

declare(strict_types=1);

namespace App\Service\Validation\Middleware;

use Symfony\Component\HttpFoundation\Request;

class ValidatorChain
{
    /** @var ValidatorInterface[] */
    private array $validators = [];

    public function addValidator(ValidatorInterface $validator): void
    {
        $this->validators[] = $validator;
    }

    public function validate(Request $request): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($request);
        }
    }
}