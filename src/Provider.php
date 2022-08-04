<?php
/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo;


use InvalidArgumentException;
use Swimtobird\KuaFuGo\Contracts\GatewayInterface;
use Swimtobird\KuaFuGo\Utils\Config;

trait Provider
{
    protected $config;

    /**
     * @var GatewayInterface
     */
    protected $gateway;

    public function __construct(string $gateway, array $config)
    {
        $this->config = new Config($config);

        $this->gateway = $this->createGateway($gateway);
    }

    /**
     * @param $gateway
     * @return GatewayInterface
     */
    public function createGateway($gateway): GatewayInterface
    {
        list($platform, $gateway) = explode('_', $gateway, 2);

        $class = __NAMESPACE__ . '\\Gateways\\' . ucfirst($platform) . '\\' . $gateway;


        if (!class_exists($class)) {
            throw new InvalidArgumentException("Sorry,Gateway {$gateway} is not supported now.");
        }

        return new $class($this->config);
    }

    /**
     * @param $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, array $arguments)
    {
        if (!method_exists($this->gateway, $method)) {
            throw new InvalidArgumentException("Sorry,it is not supported {$method} method now.");
        }

        if(!empty($arguments)){
            return $this->gateway->$method($arguments[0]);
        }else{
            return $this->gateway->$method();
        }
    }
}