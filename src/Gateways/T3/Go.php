<?php
/**
 *
 * User: swimtobird
 * Date: 2021-01-19
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\T3;

use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;
use Swimtobird\KuaFuGo\Gateways\T3\AbstractGateway;
use function GuzzleHttp\Psr7\str;

class Go extends AbstractGateway implements GoGatewayInterface
{

    /**
     * 创建订单
     * @param array $params
     * @return mixed
     * 请求方法 POST Content-Type: application/x-www-form-urlencoded
     */
    public function createOrder(array $params)
    {

        //必要字段
        $personalParams = [
            'tripartiteOrderId' => (string)$params['tripartiteOrderId'], //第三方订单ID
            'startLocationLng' => (string)$params['startLocationLng'],//出发地经度
            'startLocationLat' => (string)$params['startLocationLat'],//出发地纬度
            'startName' => (string)$params['startName'],//出发地名称
            'endLocationLng'=>(string)$params['endLocationLng'],//目的地经度
            'endLocationLat'=>(string)$params['endLocationLat'],//目的地纬度
            'endName' => (string)$params['endName'],//目的地名称
            'typeTime' => (int)$params['typeTime'],//订单类型（时效性）：1 实时订单， 2 预约订单
            'typeModule' => (int)$params['']
        ];
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/orderEvaluation',
            'method' => 'post'
        ], $total_params);
    }

    public function getValuation(array $params)
    {
        // TODO: Implement getValuation() method.
    }

    public function getOrder(array $params)
    {
        // TODO: Implement getOrder() method.
    }

    public function cancelOrder(array $params)
    {
        // TODO: Implement cancelOrder() method.
    }

    public function getOrderList(array $params)
    {
        // TODO: Implement getOrderList() method.
    }

    public function getDriverLocation(array $params)
    {
        // TODO: Implement getDriverLocation() method.
    }

    public function saveOrderScore(array $params)
    {
        // TODO: Implement saveOrderScore() method.
    }
}