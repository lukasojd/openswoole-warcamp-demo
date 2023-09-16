<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Enum\RequestMethod;
use Exception;
use JsonException;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Nette\Utils\Json;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseFunctional extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->client->disableReboot();
    }

    /**
     * @param mixed[] $data
     * @throws JsonException
     */
    public function sendRequest(RequestMethod $requestMethod, string $endpoint, array $data): void
    {
        $this->client->request(
            $requestMethod->value,
            $endpoint,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            Json::encode($data)
        );
    }

    /**
     * @throws Exception
     */
    protected function getDatabaseTool(): AbstractDatabaseTool
    {
        $databaseToolCollection = self::getContainer()
            ->get(DatabaseToolCollection::class);
        self::assertInstanceOf(DatabaseToolCollection::class, $databaseToolCollection);

        return $databaseToolCollection->get();
    }
}
