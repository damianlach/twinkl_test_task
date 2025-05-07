<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Entity\Subscription;
use App\Provider\ResponseProvider;
use App\Repository\SubscriptionRepository;
use App\Service\Email\Subscription\WelcomeSubscriptionEmailService;
use App\Service\Validation\Middleware\ValidatorChain;
use App\Validator\Components\Subscription\SubscriptionAddComponent;
use App\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/subscription', name: 'api_v1_subscription_')]
class SubscriptionController extends AbstractController
{
    public function __construct(
        private readonly SubscriptionRepository $subscriptionRepository,
        private readonly Validator $validator,
        private readonly WelcomeSubscriptionEmailService $welcomeEmailService,
        private readonly ValidatorChain $validatorChain
    ) {
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(
        Request $request
    ): JsonResponse {
        // Subscription validator
        try {
            $data = $request->toArray();
        } catch (\Throwable $e) {
            return $this->json(new ResponseProvider(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage(),
                [$request->getContent()],
            ));
        }

        $checkData = new SubscriptionAddComponent($data);
        $errors = $this->validator->valid($checkData);

        if ([] !== $errors) {
            return $this->json(new ResponseProvider(
                Response::HTTP_BAD_REQUEST,
                'Invalid request',
                null,
                $errors
            ));
        }

        $subscription = $this->subscriptionRepository->findOneBy(['email' => $data['email']]);
        if ($subscription instanceof Subscription) {
            return $this->json(new ResponseProvider(
                Response::HTTP_CONFLICT,
                'Subscription exist',
                null,
                ['Subscription exist in database']
            ));
        }

        $result = $this->subscriptionRepository->add($data);
        if (null !== $result) {
            return $this->json(new ResponseProvider(
                Response::HTTP_CONFLICT,
                'Somthing go wrong during user save',
                null,
                [$result]
            ));
        }

        $newSubscription = $this->subscriptionRepository->findOneBy(['email' => $data['email']]);
        $this->welcomeEmailService->sendEmail($newSubscription);

        return $this->json(new ResponseProvider(
            Response::HTTP_CREATED,
            'Subscription was added'
        ));
    }
}