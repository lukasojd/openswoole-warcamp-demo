<?php

declare(strict_types=1);

namespace App\Facade;

use App\Handler\UserHandler;
use App\Response\User\UserListResponse;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final readonly class UserCacheHandler
{
    public function __construct(
        private UserHandler $userHandler,
        private TagAwareCacheInterface $cache,
    ) {
    }

    private const CACHE_KEY = 'user_list';

    private const CACHE_TTL = 3600;

    private const CACHE_TAGS = ['users'];

    public function getUserList(): UserListResponse
    {
        return $this->cache->get(
            self::CACHE_KEY,
            function (ItemInterface $item): UserListResponse {
                $item->expiresAfter(self::CACHE_TTL);
                $item->tag(self::CACHE_TAGS);

                return $this->userHandler->getUserList();
            }
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function invalidateCache(): void
    {
        $this->cache->invalidateTags(self::CACHE_TAGS);
    }
}
