<?php

declare(strict_types=1);

namespace App\Response\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserCreateResponse extends JsonResponse
{
    public function __construct(User $user)
    {
        parent::__construct(
            $this->create(user: $user)
        );
    }

    /**
     * @return mixed[]
     */
    public function create(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'description' => $user->getDescription(),
        ];
    }
}
