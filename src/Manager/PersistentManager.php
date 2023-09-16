<?php

declare(strict_types=1);

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

final readonly class PersistentManager
{
    public function __construct(
        public EntityManagerInterface $entityManager
    ) {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function flushAndClear(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
