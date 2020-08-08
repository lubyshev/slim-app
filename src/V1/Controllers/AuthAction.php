<?php
declare(strict_types=1);

namespace App\V1\Controllers;

use App\Controllers\ActionAbstract;
use App\Helpers\ApiParamsHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthAction extends ActionAbstract
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data   = [
            'success' => false,
            'version' => $this->settings->getVersion(),
        ];
        $params = $request->getParsedBody();
        if (!isset($params['apiKey'], $params['apiSecret'])) {
            $data['error'] = [
                'code'    => 400,
                'message' => 'Bad request.',
            ];
        } else {
            if ($this->settings->getApiKey() !== $params['apiKey']) {
                $data['error'] = [
                    'code'    => 404,
                    'message' => 'Page not found.',
                ];
            }
        }
        if (!isset($data['error'])) {
            $apiClient = null;
            foreach ($this->settings->getSecrets() as $client => $secret) {
                if ($secret === $params['apiSecret']) {
                    $apiClient = $client;
                    break;
                }
            }
            if (!$apiClient) {
                $data['error'] = [
                    'code'    => 403,
                    'message' => 'Access denied.',
                ];
            }
        }
        if (!isset($data ['error'])) {
            $data['success'] = true;
            $data['client']  = $apiClient;
            $data['token']   = ApiParamsHelper::createGuid();
        }

        $response->getBody()->write(json_encode($data));
        $code = !isset($data['error']) ? 200 : $data['error']['code'];

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }

}
