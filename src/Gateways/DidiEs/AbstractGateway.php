<?php
/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\DidiEs;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Swimtobird\KuaFuGo\Contracts\GatewayInterface;
use Swimtobird\KuaFuGo\Exceptions\GatewayRequestException;
use Swimtobird\KuaFuGo\Utils\Config;

abstract class AbstractGateway implements GatewayInterface
{
    /**
     * @var Client $client
     */
    protected $client;

    const HOST = 'https://api.es.xiaojukeji.com';

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->client = new Client();
    }

    public function request(array $urls, array $data)
    {
        $method = $urls['method'];
        $url = $urls['url'];
        ksort($data);
        $data['sign'] = $this->getSign($data);
        /**
         * @var ResponseInterface $response
         */
        $response = $this->client->$method(self::HOST . $url, [
            $this->getRequestMethod($method) => $data
        ]);

        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() >= 500) {
            throw new GatewayRequestException('DidiEs GatewayError:Server is 500');
        }

        if (isset($result['errno']) && $result['errno'] != '0') {
            throw new GatewayRequestException(
                sprintf(
                    'DidiEs Gateway Error: %s, %s',
                    $result['errno'] ?? '',
                    $result['errmsg'] ?? ''
                )
            );
        }
        return $result;
    }

    protected function getSign(array $data): string
    {
        $data['sign_key'] = $this->config->get('sign_key');

        ksort($data); //对数组(map)根据键名升序排序

        $str = '';

        foreach ($data as $k => $v) {
            if ('' == $str) {
                $str .= $k . '=' . trim($v);
            } else {
                $str .= '&' . $k . '=' . trim($v);
            }

        }
        return md5($str);
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