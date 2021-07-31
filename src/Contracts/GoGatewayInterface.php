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
     * 本接口用于创建订单，获取订单号等信息。
     * @param array $params
     * @return mixed
     */
    public function createOrder(array $params);


    /**
     * 获取车型预估价
     * 本接口用于获取行程预估价格信息
     * @param array $params
     * @return mixed
     */
    public function getValuation(array $params);


    /**
     * 获取订单详情
     * 本接口根据订单ID返回订单详情，包括司机信息，车辆信息等，车辆ID，费用详情。可轮询订单状态时使用，大概10s/订单/次
     * @param array $params
     * @return mixed
     */
    public function getOrder(array $params);


    /**
     * 取消订单
     * 本接口用于取消订单。行程状态在已到达之前取消订单不会产生费用。
     * @param array $params
     * @return mixed
     */
    public function cancelOrder(array $params);


    /**
     * 获取订单列表
     * 查询用户订单列表
     * @param array $params
     * @return mixed
     */
    public function getOrderList(array $params);


    /**
     * 司机位置
     * 本接口根据订单ID，查询司机当前位置。 在司机接单（103状态）及以后有效。可轮询司机位置时使用，大概10S/订单/次。
     * @param array $params
     * @return mixed
     */
    public function getDriverLocation(array $params);


    /**
     * 计费规则接口
     * 本接口用于打车平台拉取网约车供应商(如祺出行开放平台)的计费规则明细信息。
     * @param array $params
     * @return mixed
     */
      public function getRule(array $params);


    /**
     * 车型费用预估列表
     * @param array $params
     * @return mixed
     */
    public function getEstimateCosts(array $params);


    /**
     * 周边车辆汇总信息
     * 本接口用于查询附近司机。
     * @param array $params
     * @return mixed
     */
    public function getAroundSearch(array $params);


    /**
     * 查询取消费
     * @param array $params
     * @return mixed
     */
    public function getCancelOrderCost(array $params);


    /**
     * 用户优惠后费用明细
     * 本接口根据订单ID，获取本行程中的总花费，费用详情等内容
     * @param array $params
     * @return mixed
     */
    public function getUserCost(array $params);


    /**
     * 申请发票
     * @param array $params
     * @return mixed
     */
    public function applyInvoice(array $params);


    /**
     * 发票查询
     * @param array $params
     * @return mixed
     */
    public function queryInvoiceDetail(array $params);


    /**
     * 发票补发
     * 1、前提：已经开票成功。2、如果出现邮箱没有收到发票等问题，乘客可通过补发重新接收发票。
     * @param array $params
     * @return mixed
     */
    public function resendInvoice(array $params);


    /**
     * 当订单完成后，可以评价司机，为司机打分。评分，可选值1到5
     * @param array $params
     * @return mixed
     */
    public function orderEvaluation(array $params);


    /**
     * 支付状态同步
     * 根据订单号上传订单支付状态。支付后调用，如果调用失败，调用方要适当重试。该同步内容不作为服务商阻拦用户下单凭据，未支付订单验证由打车平台统一处理。
     * @param array $params
     * @return mixed
     */
    public function getPayStatus(array $params);

    /**
     * 电子围栏接口
     * 查询上下车经纬度是否在围栏范围内
     * @param array $params
     * @return mixed
     */
    public function electronicFence(array $params);


    /**
     * 司机抢单结果通知(待定)
     * 打车平台调用该接口通知供应商是否抢单成功(抢单失败则取消订单)
     * @param array $params
     * @return mixed
     */
    public function driverGrabCallBack(array $params);


    /**
     * 显示距离目的地的里程和时间
     * @param array $params
     * @return mixed
     */
    public function getEta(array $params);


    /**
     * 抢单结果回调
     * 本接口用于抢单模式结果回调。订单抢单之后,将抢单结果告知网约车供应商。
     * @param array $params
     * @return mixed
     */
    public function grabCallBack(array $params);


    /**
     * 查询城市列表
     * 查询已开通业务城市列表
     * @param array $params
     * @return mixed
     */
    public function queryCityList(array $params);


    /**
     * 查询企业订单列表
     * @param array $params
     * @return mixed
     */
    public function pageQuery(array $params);
}