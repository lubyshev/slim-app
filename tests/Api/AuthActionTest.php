<?php
declare(strict_types=1);

namespace Api;

require_once __DIR__.'/../../vendor/autoload.php';

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface as StatusCodes;

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
        $response = $client->post($path, ['json' => $data,]);
        $message  = sprintf(
            '%d. Status code: %d, body: "%s".',
            $number, $response->getStatusCode(), $response->getBody()
        );
        $this->checkRequestResult($number, $response, $message);
    }

    /**
     * Генератор данных для теста.
     *
     * @return array[]
     */
    public function authProvider(): array
    {
        return require __DIR__.'/Providers/AuthActionTestProvider.php';
    }

    /**
     * Проверка результатов запроса.
     *
     * @param int               $number   Номер теста.
     * @param ResponseInterface $response Ответ на запрос.
     * @param string            $message  Отладочная информация.
     */
    private function checkRequestResult(int $number, ResponseInterface $response, string $message)
    {
        $expectedCode = ([
            1 => StatusCodes::STATUS_GONE, // Устаревшее API.
            2 => StatusCodes::STATUS_BAD_REQUEST, // Неверные параметры запроса.
            3 => StatusCodes::STATUS_OK, // OK.
            4 => StatusCodes::STATUS_NOT_FOUND, // Неверный параметр apiKey.
            5 => StatusCodes::STATUS_FORBIDDEN, // Неверный параметр apiSecret.
        ])[$number];
        $this->assertEquals($expectedCode, $response->getStatusCode(), $message);
    }

}
