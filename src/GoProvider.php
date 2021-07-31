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
 * @method  GoGatewayInterface createOrder(array $params) //创建订单
 * @method  GoGatewayInterface getValuation(array $params) //获取车型预估价
 * @method  GoGatewayInterface getOrder(array $params) //订单详情
 * @method  GoGatewayInterface cancelOrder(array $params) //取消订单
 * @method  GoGatewayInterface getOrderList(array $params)//查询用户订单列表
 * @method  GoGatewayInterface getDriverLocation(array $params) //司机位置
 * @method  GoGatewayInterface getRule(array $params) //计费规则接口
 * @method  GoGatewayInterface getEstimateCosts(array $params) //车型费用预估列表
 * @method  GoGatewayInterface getAroundSearch(array $params) //周边车辆汇总信息
 * @method  GoGatewayInterface getCancelOrderCost(array $params) //查询取消费
 * @method  GoGatewayInterface getUserCost(array $params) //用户优惠后费用明细
 * @method  GoGatewayInterface applyInvoice(array $params)//申请发票
 * @method  GoGatewayInterface queryInvoiceDetail(array $params)//发票查询
 * @method  GoGatewayInterface resendInvoice(array $params)//发票补发
 * @method  GoGatewayInterface orderEvaluation(array $params)//司机评价
 * @method  GoGatewayInterface getPayStatus(array $params)//支付状态同步
 * @method  GoGatewayInterface electronicFence(array $params)//电子围栏接口
 * @method  GoGatewayInterface driverGrabCallBack(array $params)//司机抢单结果通知(待定)
 * @method  GoGatewayInterface getEta(array $params)//显示距离目的地的里程和时间
 * @method  GoGatewayInterface grabCallBack(array $params)//抢单结果回调
 * @method  GoGatewayInterface queryCityList(array $params)//查询城市列表
 * @method  GoGatewayInterface pageQuery(array $params) //查询企业订单列表
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