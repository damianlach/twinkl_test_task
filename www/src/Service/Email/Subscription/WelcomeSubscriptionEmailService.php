<?php

namespace App\Service\Email\Subscription;

use App\Entity\Subscription;
use App\Enum\RoleType;
use App\Service\Email\EmailSenderService;

class WelcomeSubscriptionEmailService implements EmailSubscriptionInterface
{

    public function __construct(private EmailSenderService $emailSenderService)
    {
    }

    public function sendEmail(Subscription $subscription): void
    {
        $template = $this->getTemplate($subscription->getRole());

        $this->emailSenderService->sendEmail($subscription->getEmail(), 'Welcome to our platform!', $template);
    }

    private function getTemplate(RoleType $role): string
    {
        return match ($role) {
            RoleType::STUDENT => "<h1>Hello, student!</h1><p>We're glad you're joining our community.</p>",
            RoleType::TEACHER => "<h1>Hello, teacher!</h1><p>Your knowledge changes the world.</p>",
            RoleType::PARENT => "<h1>Hello, parent!</h1><p>Your child's education is important to us.</p>",
            RoleType::TUTOR => "<h1>Hello, tutor!</h1><p>Your support is invaluable.</p>",
        };
    }
}