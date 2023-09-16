<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\UserDoesNotExistException;
use App\Manager\PersistentManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class UserRepository
{
    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $entityRepository;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private PersistentManager $persistentManager,
    ) {
        $this->entityRepository = $entityManager->getRepository(User::class);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->persistentManager->flush();
    }

    /**
     * @throws UserDoesNotExistException
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->entityRepository->findOneBy([
            'email' => $email,
        ]);

        if (! $user instanceof User) {
            throw new UserDoesNotExistException('User does not exist');
        }

        return $user;
    }

    /**
     * @return array<User>
     */
    public function getUserList(): array
    {
        return $this->entityRepository->findAll();
    }
}
