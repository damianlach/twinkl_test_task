<?php

declare(strict_types=1);

namespace App\Service\Email;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSenderService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer, private readonly LoggerInterface $logger)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $to, string $subject, string $content): void
    {
        try {
            $email = (new Email())
                ->from('noreply@twinkl.com')
                ->to($to)
                ->subject($subject)
                ->html($content);

            $this->mailer->send($email);

        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }
}