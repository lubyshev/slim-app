<?php
declare(strict_types=1);

namespace Api;

require_once __DIR__.'/../../vendor/autoload.php';

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

(Dotenv::createImmutable(realpath(__DIR__.'/../..')))->load();

class AuthActionTest extends TestCase
{

    /**
     * Тест аутентификации.
     *
     * @param int    $number Номер теста.
     * @param string $path   Путь URI.
     * @param array  $data   Данные для POST.
     *
     * @dataProvider authProvider
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPost(int $number, string $path, array $data)
    {
        $client   = new Client([
            'base_uri'    => env('HTTP_URI'),
            'timeout'     => 2.0,
            'http_errors' => false,
        ]);
        $response = $client->post($path, [
            'json' => $data,
        ]);
        $message  = sprintf(
            '%d. Status code: %d, body: "%s".',
            $number,
            $response->getStatusCode(),
            $response->getBody()
        );
        switch ($number) {
            case 1:
                $this->assertEquals(410, $response->getStatusCode(), $message);
                break;
            case 2:
                $this->assertEquals(400, $response->getStatusCode(), $message);
                break;
            case 3:
                $this->assertEquals(200, $response->getStatusCode(), $message);
                break;
            case 4:
                $this->assertEquals(404, $response->getStatusCode(), $message);
                break;
            case 5:
                $this->assertEquals(403, $response->getStatusCode(), $message);
                break;
        }
    }

    /**
     * Генератор данных для теста.
     *
     * @return array[]
     */
    public function authProvider(): array
    {
        return [
            [
                1,
                'api/v0/auth',
                [
                    'apiKey' => '26e19771-55c8-4581-a6cc-4acad8ff88db',
                ],
            ],
            [
                2,
                'api/v1/auth',
                [
                    'apiKey' => '26e19771-55c8-4581-a6cc-4acad8ff88db',
                ],
            ],
            [
                3,
                'api/v1/auth',
                [
                    'apiKey'    => '26e19771-55c8-4581-a6cc-4acad8ff88db',
                    'apiSecret' => '949229ea-4823-49a2-bce3-ba774cc768fd',
                ],
            ],
            [
                4,
                'api/v1/auth',
                [
                    'apiKey'    => 'xxx',
                    'apiSecret' => '7d1da9e9-f254-4a22-b785-0046789ff37d',
                ],
            ],
            [
                5,
                'api/v1/auth',
                [
                    'apiKey'    => '26e19771-55c8-4581-a6cc-4acad8ff88db',
                    'apiSecret' => 'xxx',
                ],
            ],
        ];
    }

}
