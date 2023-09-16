<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_82);
    $rectorConfig->importNames();

    $rectorConfig->sets([
        SymfonyLevelSetList::UP_TO_SYMFONY_63,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
        LevelSetList::UP_TO_PHP_82,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        SetList::PRIVATIZATION,
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
        DoctrineSetList::DOCTRINE_COMMON_20,
        DoctrineSetList::DOCTRINE_DBAL_30,
        DoctrineSetList::DOCTRINE_ORM_29,
    ]);

    $rectorConfig->skip(
        [
            \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class
            => [
                __DIR__ . '/tests/Functional/BaseFunctional.php',
            ],
            PreferPHPUnitThisCallRector::class,
        ]
    );
};
