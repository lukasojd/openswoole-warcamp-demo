<?php

declare(strict_types=1);

namespace App\Facade;

use App\Dto\Input\User\CreateUserQuery;
use App\Exception\UserAlreadyExistsException;
use App\Handler\UserHandler;
use App\Response\User\UserCreateResponse;
use App\Response\User\UserListResponse;

final readonly class UserFacade
{
    public function __construct(
        private UserHandler $userHandler,
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function createUser(CreateUserQuery $query): UserCreateResponse
    {
        return new UserCreateResponse($this->userHandler->createAndProcessNewUser(createUserQuery: $query));
    }

    public function getList(): UserListResponse
    {
        return new UserListResponse($this->userHandler->getUserList());
    }
}
