<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\Ruqi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Swimtobird\KuaFuGo\Contracts\GatewayInterface;
use Swimtobird\KuaFuGo\Exceptions\GatewayRequestException;
use Swimtobird\KuaFuGo\Utils\Config;

abstract class AbstractGateway implements GatewayInterface
{
    /**
     * @var Config $config
     */
    protected $config;

    protected $request_id;

    /**
     * @var Client $client
     */
    protected $client;

    const HOST = 'www.baidu.com';

    /**
     * AbstractGateway constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->client = new Client();
    }

    /**
     * @param array $url
     * @param array $data
     * @return mixed
     */
    public function request(array $urls, array $data)
    {
        $method = $urls['method'];
        $url = $urls['url'];

        /**
         * @var ResponseInterface $response
         */
        $response = $this->client->$method(self::HOST . $url, [
            $this->getRequestMethod($method) => $data
        ]);

        $result = json_decode($response->getBody(),true);

        if ($response->getStatusCode()>=500){
            throw new GatewayRequestException('Ruqi GatewayError:Server is 500');
        }

        if (isset($result['state']) && 'FAILURE' === $result['state']){
            throw new GatewayRequestException(
                sprintf(
                'Ruqi Gateway Error: %s, %s',
                $result['error']['code'] ?? '',
                $result['error']['message'] ?? ''
                )
            );
        }
        return $result;
    }

    /**
     * @param string $method
     * @return string
     */
    protected function getRequestMethod(string $method): string
    {
        switch (strtolower($method)) {
            case 'get':
                return 'query';
            case 'post':
                return 'form_params';
        }
    }
}