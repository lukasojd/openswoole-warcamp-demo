<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Enum\RequestMethod;
use App\Tests\Functional\BaseFunctional;
use JsonException;

final class CreateUserTest extends BaseFunctional
{
    /**
     * @throws JsonException
     */
    public function testCreateUser(): void
    {
        $this->sendRequest(requestMethod: RequestMethod::PUT, endpoint: '/user', data: [
            'email' => 'test@test.cz',
            'name' => 'test',
            'description' => 'test',
        ]);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        self::assertResponseIsSuccessful();
        $this->assertIsString($content);
        $this->assertJson($content);
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($data);
        $data['id'] = '00000000-0000-0000-0000-000000000000';
        self::assertSame([
            'id' => '00000000-0000-0000-0000-000000000000',
            'email' => 'test@test.cz',
            'name' => 'test',
            'description' => 'test',
        ], $data);
    }
}
