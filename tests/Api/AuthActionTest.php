<?php
declare(strict_types=1);

namespace Api;

require_once __DIR__.'/../../vendor/autoload.php';

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use \Psr\Http\Message\ResponseInterface;

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
        return require __DIR__.'/Providers/AuthTestProvider.php';
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
            1 => 410, // Устаревшее API.
            2 => 400, // Неверные параметры запроса.
            3 => 200, // OK.
            4 => 404, // Неверный параметр apiKey.
            5 => 403, // Неверный параметр apiSecret.
        ])[$number];
        $this->assertEquals($expectedCode, $response->getStatusCode(), $message);
    }

}
