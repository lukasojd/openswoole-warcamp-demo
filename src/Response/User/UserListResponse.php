<?php

declare(strict_types=1);

namespace App\Response\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserListResponse extends JsonResponse
{
    /**
     * @param User[] $users
     */
    public function __construct(array $users)
    {
        parent::__construct(
            $this->create(usersEntity: $users)
        );
    }

    /**
     * @param User[] $usersEntity
     * @return mixed[]
     */
    public function create(array $usersEntity): array
    {
        $users = [];

        foreach ($usersEntity as $user) {
            $users[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'description' => $user->getDescription(),
            ];
        }

        return $users;
    }
}
