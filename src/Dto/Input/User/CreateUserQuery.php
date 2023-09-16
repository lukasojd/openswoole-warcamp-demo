<?php

declare(strict_types=1);

namespace App\Dto\Input\User;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserQuery
{
    public function __construct(
        #[Assert\NotNull(message: 'Name is required'),
            Assert\Type(type: 'string', message: 'Name is not valid'),
        ]
        public string $name,
        #[Assert\NotNull(message: 'Email is required'),
            Assert\Type(type: 'string', message: 'Email is not valid'),
        ]
        public string $email,
        #[Assert\NotNull(message: 'Description is required'),
            Assert\Type(type: 'string', message: 'Description is not valid'),
        ]
        public string $description,
    ) {
    }
}
