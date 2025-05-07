<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Subscription;
use App\Enum\RoleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Subscription>
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                  $registry,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($registry, Subscription::class);
    }

    public function add(array $data): ?string
    {
        $this->getEntityManager()->beginTransaction();

        try {
            $subscription = (new Subscription())
                ->setFirstName($data['first_name'])
                ->setLastName($data['last_name'])
                ->setEmail($data['email'])
                ->setRole(RoleType::from($data['role']));
            $this->getEntityManager()->persist($subscription);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Throwable $exception) {
            $this->getEntityManager()->rollback();
            $this->logger->error($exception->getMessage());
            return $exception->getMessage();
        }
        return null;
    }

}