<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\Input\User\CreateUserQuery;
use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserDoesNotExistException;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Response\User\UserListResponse;

final readonly class UserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private UserFactory $userFactory
    ) {
    }

    /**
     * @throws UserDoesNotExistException
     */
    private function getUserByQuery(CreateUserQuery $createUserQuery): User
    {
        return $this->userRepository->getUserByEmail(
            email: $createUserQuery->email
        );
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function createAndProcessNewUser(CreateUserQuery $createUserQuery): User
    {
        try {
            $this->getUserByQuery(
                $createUserQuery
            );

            throw new UserAlreadyExistsException(
                sprintf('User with email: %s already exists.', $createUserQuery->email)
            );
        } catch (UserDoesNotExistException) {
            $user = $this->userFactory->create($createUserQuery);
            $this->userRepository->save($user);

            return $user;
        }
    }

    public function getUserList(): UserListResponse
    {
        return new UserListResponse($this->userRepository->getUserList());
    }
}
