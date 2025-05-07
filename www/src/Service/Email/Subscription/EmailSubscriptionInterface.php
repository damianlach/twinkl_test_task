<?php

namespace App\Service\Email\Subscription;

use App\Entity\Subscription;

interface EmailSubscriptionInterface
{
    public function sendEmail(Subscription $subscription): void;
}