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
        //去除掉最后一个&号
        $result=substr($result, 0, -1);


        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($this->config['privateKey'], 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        $key = openssl_get_privatekey($privateKey);

        openssl_sign($result, $signature, $key,OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        //进行base64编码
        return base64_encode($signature);
    }
}