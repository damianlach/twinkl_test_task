<?php

namespace App\Service\Validation\Middleware;

use Symfony\Component\HttpFoundation\Request;

interface ValidatorInterface
{
    public function validate(Request $request): void;
}