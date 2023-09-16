<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Input\User\CreateUserQuery;
use App\Enum\RequestMethod;
use App\Exception\UserAlreadyExistsException;
use App\Facade\UserFacade;
use App\Response\User\UserCreateResponse;
use App\Response\User\UserListResponse;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final readonly class UserController
{
    public function __construct(
        private UserFacade $userFacade
    ) {
    }

    #[Route('/users', methods: [RequestMethod::GET->value])]
    public function getUsers(): UserListResponse
    {
        return $this->userFacade->getList();
    }

    #[Route('/users/cached', methods: [RequestMethod::GET->value])]
    public function getCacheList(): UserListResponse
    {
        return $this->userFacade->getCacheList();
    }

    /**
     * @throws UserAlreadyExistsException
     * @throws InvalidArgumentException
     */
    #[Route('/user', methods: [RequestMethod::PUT->value])]
    public function createUser(#[MapRequestPayload] CreateUserQuery $getUserDto): UserCreateResponse
    {
        return $this->userFacade->createUser($getUserDto);
    }
}
