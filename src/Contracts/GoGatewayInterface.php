<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Contracts;


interface GoGatewayInterface
{
    /**
     * 创建订单
     * @param array $params
     * @return mixed
     */
    public function createOrder(array $params);

    /**
     * 获取估价
     * @param array $params
     * @return mixed
     */
    public function getValuation(array $params);

    /**
     * 获取订单详情
     * @param array $params
     * @return mixed
     */
    public function getOrder(array $params);

    /**
     * 取消订单
     * @param array $params
     * @return mixed
     */
    public function cancelOrder(array $params);

    /**
     * 获取订单列表
     * @param array $params
     * @return mixed
     */
    public function getOrderList(array $params);

    /**
     * 获取司机实时位置
     * @param array $params
     * @return mixed
     */
    public function getDriverLocation(array $params);

    /**
     * 司机评分
     * @param array $params
     * @return mixed
     */
    public function saveOrderScore(array $params);
}