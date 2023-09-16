<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Input\User\CreateUserQuery;
use App\Entity\User;

final class UserFactory
{
    public function create(CreateUserQuery $getUserQuery): User
    {
        return new User(
            name: $getUserQuery->name,
            email: $getUserQuery->email,
            description: $getUserQuery->description,
        );
    }
}
