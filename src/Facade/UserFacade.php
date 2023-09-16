<?php

declare(strict_types=1);

namespace App\Facade;

use App\Dto\Input\User\CreateUserQuery;
use App\Exception\UserAlreadyExistsException;
use App\Handler\UserHandler;
use App\Response\User\UserCreateResponse;
use App\Response\User\UserListResponse;
use Psr\Cache\InvalidArgumentException;

final readonly class UserFacade
{
    public function __construct(
        private UserHandler $userHandler,
        private UserCacheHandler $userCacheHandler
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     * @throws InvalidArgumentException
     */
    public function createUser(CreateUserQuery $query): UserCreateResponse
    {
        $this->userCacheHandler->invalidateCache();

        return new UserCreateResponse($this->userHandler->createAndProcessNewUser(createUserQuery: $query));
    }

    public function getList(): UserListResponse
    {
        return $this->userHandler->getUserList();
    }

    public function getCacheList(): UserListResponse
    {
        return $this->userHandler->getUserList();
    }
}
