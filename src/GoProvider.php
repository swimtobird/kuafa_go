<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo;


use InvalidArgumentException;
use Swimtobird\KuaFuGo\Contracts\GatewayInterface;
use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;
use Swimtobird\KuaFuGo\Contracts\ProfitSharingGatewayInterface;
use Swimtobird\KuaFuGo\Utils\Config;

/**
 * Class GoProvider
 * @package Swimtobird\YeePay
 *
 * @method  GoGatewayInterface createOrder(array $params)
 * @method  GoGatewayInterface getValuation(array $params)
 * @method  GoGatewayInterface getOrder(array $params)
 * @method  GoGatewayInterface cancelOrder(array $params)
 * @method  GoGatewayInterface getOrderList(array $params)
 * @method  GoGatewayInterface getDriverLocation(array $params)
 * @method  GoGatewayInterface saveOrderScore(array $params)
 */
class GoProvider
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

        return $this->gateway->$method($arguments[0]);
    }
}