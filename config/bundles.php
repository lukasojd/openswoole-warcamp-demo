<?php

declare(strict_types=1);

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Liip\TestFixturesBundle\LiipTestFixturesBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;

return [
    FrameworkBundle::class => [
        'all' => true,
    ],
    MakerBundle::class => [
        'dev' => true,
    ],
    MonologBundle::class => [
        'all' => true,
    ],
    DoctrineBundle::class => [
        'all' => true,
    ],
    DoctrineMigrationsBundle::class => [
        'all' => true,
    ],
    DAMADoctrineTestBundle::class => [
        'test' => true,
    ],
    LiipTestFixturesBundle::class => [
        'dev' => true,
        'test' => true,
    ],
    DoctrineFixturesBundle::class => [
        'dev' => true,
        'test' => true,
    ],
];
