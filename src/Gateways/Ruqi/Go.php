<?php
/**
 *
 * User: swimtobird
 * Date: 2021-01-19
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\Ruqi;

use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;

class Go extends AbstractGateway implements GoGatewayInterface
{
    public function getValuation(array $params)
    {
        return $this->request([
            'url' => '/',
            'method' => 'post'
        ],$params);
    }

    public function createOrder(array $params)
    {
        // TODO: Implement createOrder() method.
    }

    public function getOrder(array $params)
    {
        // TODO: Implement getOrder() method.
    }

    public function getOrderList(array $params)
    {
        // TODO: Implement getOrderList() method.
    }

    public function cancelOrder(array $params)
    {
        // TODO: Implement cancelOrder() method.
    }
}