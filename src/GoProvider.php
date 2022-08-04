<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo;

use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;

/**
 * Class GoProvider
 * @package Swimtobird\KuaFuGo
 *
 * @method  GoGatewayInterface createOrder(array $params)
 * @method  GoGatewayInterface getValuation(array $params)
 * @method  GoGatewayInterface getOrder(array $params)
 * @method  GoGatewayInterface cancelOrder(array $params)
 * @method  GoGatewayInterface getOrderList(array $params)
 * @method  GoGatewayInterface getDriverLocation(array $params)
 * @method  GoGatewayInterface saveOrderScore(array $params)
 * @method  GoGatewayInterface driverGrabCallBack(array $params)
 * @method  GoGatewayInterface getPayStatus(array $params)
 */
class GoProvider
{
    use Provider;
}