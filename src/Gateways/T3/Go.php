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

        //非必要字段
        $item = [
            'passengerVirtualPhone' => 'string', //乘客虚拟号码
            'passengerName' => 'string', //乘客姓名
            'generationPhone' => 'string',//代叫人手机号
            'generationName' => 'string',//代叫人姓名
            'startAddress' => 'string', //出发地详细地址
            'endAddress' => 'string',//目的地详细地址
            'departureTime' => 'int', //出发时间 (毫秒级时间戳) 预约单需超过当前时间30分钟
            'serviceId' => 'int', //服务类型1、用车，2、租车（暂未开放），3、接机，4、送机
            'flightNo' => 'string', //航班号
            'flightDate' => 'string',//航班起飞日期
            'delayTime' => 'int',//落地后多长时间用车，单位（S），接机单必传
            'airCode' => 'string' //到达机场三字码，接机单必传
        ];

        //必要字段
        $personalParams = [
            'tripartiteOrderId' => (string)$params['tripartiteOrderId'], //第三方订单ID
            'startLocationLng' => (string)$params['startLocationLng'],//出发地经度
            'startLocationLat' => (string)$params['startLocationLat'],//出发地纬度
            'startName' => (string)$params['startName'],//出发地名称
            'endLocationLng' => (string)$params['endLocationLng'],//目的地经度
            'endLocationLat' => (string)$params['endLocationLat'],//目的地纬度
            'endName' => (string)$params['endName'],//目的地名称
            'typeTime' => (int)$params['typeTime'],//订单类型（时效性）：1 实时订单， 2 预约订单
            'typeModule' => (int)$params['typeModule'],//产品类型
            'vehicleType' => (int)$params['vehicleType'],//车辆等级
            'passengerPhone' => (string)$params['passengerPhone'],//乘客手机号
            'tripartitePassengerId' => (string)$params['tripartitePassengerId'],//第三方用户唯一ID
        ];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config = json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/order/create',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 预估费用
     * @param array $params
     * @return mixed
     * 请求方法:POST Content-Type: application/x-www-form-urlencoded
     */
    public function getValuation(array $params)
    {
        //非必要字段
        $item = [
            'platformOrderNo' => 'string', //订单号,修改目的地的预估必填
            'estimatePriceType' => 'int', //预估类型,修改目的地预估时必填,取值1
            'currentLocationLng' => 'string', //当前位置经度,修改目的地时必填
            'currentLocationLat' => 'string', //当前位置纬度,修改目的地时必填
            'startName' => 'string', //出发地名称
            'endName' => 'string',//目的地名称
            'departureTime' => 'int', //出发时间 (毫秒级时间戳) 预约单需超过当前时间30分钟,（预约单，送机单必填，接机单建议填写）
            'serviceId' => 'int', //服务类型1、用车，2、租车（暂未开放），3、接机，4、送机（接送机必填）
            'flightNo' => 'string', //航班号（接机必填）
            'flightDate' => 'string', //航班起飞日期（接机必填）
            'delayTime' => 'int', //落地后多长时间用车，单位（S），接机单必传（接机必填）
            'airCode' => 'string' //到达机场三字码，接机单必传（接机必填）
        ];

        //必要字段
        $personalParams = [
            'startLocationLng' => (string)$params['startLocationLng'], //出发地经度
            'startLocationLat' => (string)$params['startLocationLat'], //出发地纬度
            'endLocationLng' => (string)$params['endLocationLng'], //目的地经度
            'endLocationLat' => (string)$params['endLocationLat'], //目的地纬度
            'typeTime' => (int)$params['typeTime'],//订单类型（时效性）：1 实时订单， 2 预约订单
            'typeModule' => (int)$params['typeModule'], //产品类型
            'vehicleTypes' => (string)$params['vehicleTypes'], //车辆等级，多个车辆等级以半角逗号分隔
        ];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config = json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/order/estimate',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 订单详情
     * @param array $params
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function getOrder(array $params)
    {

        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //平台订单号
            'tripartiteOrderId' => (string)$params['tripartiteOrderId'], //第三方订单ID
        ];

        //去除config中的token
        $config = json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/order/detail',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 取消订单
     * @param array $params
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function cancelOrder(array $params)
    {

        //非必要字段
        $item = [
            'reason' => 'string', //取消原因
        ];

        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //平台订单号
            'tripartiteOrderId' => (string)$params['tripartiteOrderId'], //第三方订单ID
        ];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config = json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/order/cancel',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 获取订单列表
     * @param array $params
     * @return mixed
     */
    public function getOrderList(array $params)
    {
        $data = ['code' => '10004', 'message' => '暂无此接口'];
        return ($data);
    }


    /**
     * 司机位置
     * @param array $params
     * @return mixed
     * 请求方法:POST Content-Type: application/x-www-form-urlencoded
     */
    public function getDriverLocation(array $params)
    {

        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //平台订单号
        ];

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/driver/driverLocation',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 司机评价
     * @param array $params
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function saveOrderScore(array $params)
    {
        //非必要字段
        $item = [
            'passengerPhone' => 'string', //乘客手机号
            'passengerName' => 'string' //乘客姓名
        ];

        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //平台订单号(T3)
            'evaluateType' => (int)$params['evaluateType'], //评价类型：1司机2平台3车辆4司机评价乘客
            'addType' => (int)$params['addType'], //评价类型：1原始评价2追加评价
            'score' => (int)$params['score'], //评分（最高5分）
            'comment' => (string)$params['comment'] //评价内容
        ];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/driver/driverEvaluate',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 价格说明H5页面
     * @param array $params
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function getPriceDesc(array $params)
    {
        //非必要字段
        $item = [
            'type' => 'int', //业务类型(1、快车 2、专车 3、包车（暂不支持）)
            'vehicleType' => 'int', //车型等级1：经济型 2：舒适型 3：行政型 4：商务型
            'cityCode' => 'int' //城市区划编码(长春 220100)
        ];

        $personalParams=[];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/order/priceDesc',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 开通城市
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function getOpenCity()
    {
        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = $config;
        return $this->request([
            'url' => '/openapi/t3/v1/city/openCity',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 附近空车
     * @param array $params
     * @return mixed
     * 请求方法: POST Content-Type: application/x-www-form-urlencoded
     */
    public function getNearByCar(array $params)
    {
        //非必要字段
        $item = [
            'typeModule' => 'int', //产品类型
            'radius' => 'int', //范围半径【单位：米】,默认2000米
            'vehicleTypes' => 'string' //车辆等级,多个车辆等级以半角逗号分隔
        ];

        //必要字段
        $personalParams = [
            'cityCode' => (string)$params['cityCode'], //城市编码(行政编码)
            'latitude' => (double)$params['latitude'], //纬度
            'longitude' => (double)$params['longitude'], //经度
        ];


        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'string') {
                    $personalParams[$key] = (string)$params[$key];
                }
                if ($value == 'int') {
                    $personalParams[$key] = (int)$params[$key];
                }
                if ($value == 'bool') {
                    $personalParams[$key] = $params[$key] ? 'true' : 'false';
                }
                if ($value == 'double') {
                    $personalParams[$key] = (double)$params[$key];
                }
            }
        }

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/driver/nearByCar',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 获取城市计价规则
     * @param array $params
     * @return mixed
     * 请求方法 POST Content-Type: application/x-www-form-urlencoded
     */
    public function getCityRules(array $params)
    {
        //必要字段
        $personalParams = [
            'cityCode' => (string)$params['cityCode'], //城市编码(行政编码)
            'vehicleType' => (int)$params['vehicleType'], //车辆类型
            'typeTime' => (int)$params['typeTime'], //用车类型（1 实时 2 预约）
        ];
        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/city/cityRules',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 修改目的地
     * @param array $params
     * @return mixed
     * 请求方法  POST  Content-Type: application/json
     */
    public function modifyDestination(array $params)
    {
        //非必要字段
        $item = [
            'waypoints' => 'obj', //途经点[{"latitude": 32.1,"longitude": 112.1,"address": "南京南站","addressDetail": "南京南站北广场东"}]
        ];

        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //订单号
            'estimateFlag' => (string)$params['estimateFlag'], //预估费用标识
            'currentLocationLat' => (double)$params['currentLocationLat'], //当前位置纬度
            'currentLocationLng' => (double)$params['currentLocationLng'], //当前位置经度
            'endLocationLat' => (double)$params['endLocationLat'], //目的地纬度
            'endLocationLng' => (double)$params['endLocationLng'], //目的地经度
            'endName' => (string)$params['endName'], //目的地名称
            'endAddress' => (string)$params['endAddress'] //目的地详细地址
        ];

        //合并
        foreach ($item as $key => $value) {
            if (array_key_exists($key, $params)) {
                if ($value == 'obj') {
                    $personalParams[$key] = (object)$params[$key];
                }
            }
        }

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/tb/order/modifyDestination',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 获取订单轨迹
     * @param array $params
     * @return mixed
     * 请求方法  POST Content-Type: application/x-www-form-urlencoded
     */
    public function getOrderStatusNotify(array $params)
    {
        //必要字段
        $personalParams = [
            'platformOrderNo' => (string)$params['platformOrderNo'], //平台订单号(T3)
        ];

        //去除config中的token
        $config=json_decode($this->config, true);
        unset($config['token']);

        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/openapi/t3/v1/driver/driverTrack',
            'method' => 'post'
        ], $total_params);
    }
}