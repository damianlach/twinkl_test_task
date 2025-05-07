<?php

namespace App\Validator\Components\Subscription;

use App\Validator\Components\ComponentsInterface;
use Symfony\Component\Validator\Constraints as Assert;
class SubscriptionAddComponent implements ComponentsInterface
{
    #[Assert\Collection(
        fields: [
            'first_name' => [
                new Assert\NotBlank(message: 'First name cannot be blank'),
            ],
            'last_name' => [
                new Assert\NotBlank(message: 'Last name cannot be blank'),
            ],
            'email' => [
                new Assert\NotBlank(message: 'Email address cannot be blank'),
                new Assert\Email(message: 'This is not a valid email format'),
            ],
            'role' => [
                new Assert\NotBlank(message: 'Role cannot be blank'),
                new Assert\Choice(choices: ['student', 'teacher', 'parent', 'tutor'], message: 'Invalid role type'),
            ],
        ],
        allowMissingFields: false,
        missingFieldsMessage: 'Missing {{ field }} field',
    )]
    public readonly array $fealds;

    public function __construct(array $fields)
    {
        $this->fealds = $fields;
    }

}