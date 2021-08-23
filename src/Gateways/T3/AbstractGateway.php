<?php


namespace Swimtobird\KuaFuGo\Gateways\T3;

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

    /**
     * @var Client $client
     */
    protected $client;

    const HOST = 'https://openabilitytest.t3go.cn:11443';

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
        ksort($data);
        $data['sign'] = $this->getSign($data);
        /**
         * @var ResponseInterface $response
         */
        $response = $this->client->$method(self::HOST . $url, [
            $this->getRequestMethod($method) => $data
        ]);

        $result = json_decode($response->getBody(),true);

        if ($response->getStatusCode()>=500){
            throw new GatewayRequestException('T3 GatewayError:Server is 500');
        }

        if (isset($result['state']) && 'FAILURE' === $result['state']){
            throw new GatewayRequestException(
                sprintf(
                    'T3 Gateway Error: %s, %s',
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


    /**
     * 生成sign
     * @param array $data 参数
     * @return string 返回sign
     *
     */
    protected function getSign(array $data): string
    {

        ksort($data);//按升序排序
        $result = '';

        foreach ($data as $key => $value) {
            if ($value){
                if (!is_array($value)) {
                    if (is_bool($value)){
                        $value = $value?'true':'false';
                    }
                    $result .= $key ."=". $value."&";
                }
                if (is_array($value) && array_values($value) === $value){
                    $result .= $key ."=". json_encode($value)."&";
                }
            }
        }
        //字符串加上token
        $total_result=$result."token=".$this->config['token'];
        return md5($total_result);
    }
}