<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Enum\RequestMethod;
use App\Facade\UserCacheHandler;
use App\Tests\Functional\BaseFunctional;
use Exception;
use JsonException;
use Psr\Cache\InvalidArgumentException;

final class ListCacheUserTest extends BaseFunctional
{
    private UserCacheHandler $userCacheHandler;

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $userCacheHandler = self::getContainer()->get(UserCacheHandler::class);
        self::assertInstanceOf(UserCacheHandler::class, $userCacheHandler);
        $this->userCacheHandler = $userCacheHandler;
        $userCacheHandler->invalidateCache();
    }

    /**
     * @throws JsonException
     */
    public function testListUser(): void
    {
        $this->sendRequest(requestMethod: RequestMethod::PUT, endpoint: '/user', data: [
            'email' => 'test@test.cz',
            'name' => 'test',
            'description' => 'test',
        ]);

        $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->sendRequest(requestMethod: RequestMethod::GET, endpoint: '/users/cached', data: []);
        $content = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertIsString($content);
        $this->assertJson($content);
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($data);
        self::assertCount(1, $data);
        self::assertArrayHasKey(0, $data);
        $data[0]['id'] = '00000000-0000-0000-0000-000000000000';
        self::assertSame([
            'id' => '00000000-0000-0000-0000-000000000000',
            'email' => 'test@test.cz',
            'name' => 'test',
            'description' => 'test',
        ], $data[0]);
    }

    /**
     * @throws JsonException
     */
    public function testListUserWithPushDatabase(): void
    {
        $this->sendRequest(requestMethod: RequestMethod::PUT, endpoint: '/user', data: [
            'email' => 'test@test.cz',
            'name' => 'test',
            'description' => 'test',
        ]);

        $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->sendRequest(requestMethod: RequestMethod::GET, endpoint: '/users/cached', data: []);
        $content = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertIsString($content);
        $this->assertJson($content);
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($data);
        self::assertCount(1, $data);

        $databaseTool = $this->getDatabaseTool();
        $databaseTool->loadFixtures([]);

        $this->userCacheHandler->invalidateCache();

        $this->sendRequest(requestMethod: RequestMethod::GET, endpoint: '/users/cached', data: []);
        $content = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertIsString($content);
        $this->assertJson($content);
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($data);
        self::assertCount(0, $data);
    }

    /**
     * @throws JsonException
     */
    public function testEmptyListUser(): void
    {
        $this->sendRequest(requestMethod: RequestMethod::GET, endpoint: '/users/cached', data: []);
        $content = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertIsString($content);
        $this->assertJson($content);
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($data);
        self::assertCount(0, $data);
    }
}
