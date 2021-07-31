<?php
/**
 *
 * User: swimtobird
 * Date: 2021-01-19
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\Ruqi;

use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;
use function GuzzleHttp\Psr7\str;

class Go extends AbstractGateway implements GoGatewayInterface
{


    /**
     * 创建订单
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function createOrder(array $params)
    {
        //非必要字段
        $item = [
            'applyNo' => 'string', //申请单编号，
            'costId' => 'string', //成本中心Id
            'costType' => 'int', //成本中心类型，0-部门，1-项目
            'custName' => 'string',//乘车人姓名
            'dispatchDuration' => 'bool',//派单持续时长,默认false
            'estimatedKm' => 'string',//预估里程(单位：米)
            'estimatedTime' => 'string', //预估用时(单位：秒)
            'fromAdCode' => 'string',//出发城市区code
            'fromAddDtl' => 'string',//出发详细地址
            'fromCityName' => 'string',//出发城市名
            'fromPoiId' => 'string', //出发POI
            'mobile' => 'string', //乘车人手机号
            'orderSource' => 'int', //下单渠道: 0默认 1小程序
            'remark' => 'string', //用车备注
            'submitAddDtl' => 'string', //用户下单详细地址
            'submitAddress' => 'string',//用户下单地址
            'submitLat' => 'double', //用户下单纬度
            'submitLng' => 'double', //用户下单经度
            'toAdCode' => 'string', //目的城市区code
            'toAddDtl' => 'string', //目的详细地址
            'toCityName' => 'string',//目的城市名
            'toPoiId' => 'string',//目的POI
            'type' => 'string', //订单乘车人类型 0：登录人(默认) 1：他人
            'userDev' => 'string', //乘客设备类型，Android 系统:IMEI，iOS 系统: IDFA(无IDFA 则使用IDFV)
            'oUid' => 'string', //乘车人在打车平台的用户id
            'Oid' => 'string', //打车平台的订单id
            'ruleId' => 'int', //用车制度id，制度用车则必要
        ];

        //必要字段
        $personalParams = [
            'carModelId' => (string)$params['carModelId'], //车型ID 1:经济型 2:舒适性 3:豪华型 4:商务型 5:出租车
            'expectStartTime' => (int)$params['expectStartTime'], //用车时间 秒级
            'fromAddress' => (string)$params['fromAddress'], //出发地址
            'fromCityCode' => (string)$params['fromCityCode'], //出发城市code
            'fromLat' => (double)$params['fromLat'], //出发地纬度
            'fromLng' => (double)$params['fromLng'], //出发地经度
            'imei' => (string)$params['imei'], //登录IMEI
            'imsi' => (string)$params['imsi'], //登录IMSI
            'mac' => (string)$params['mac'], //登录移动终端硬件标识 / 登录MAC
            'prodType' => (string)$params['prodType'],//产品类型：1实时订单 2预约订单 3接机 4送机 5包车租赁
            'sceneId' => (int)$params['sceneId'],//场景id
            'toAddress' => (string)$params['toAddress'],//目的地址
            'toCityCode' => (string)$params['toCityCode'],//目的城市code
            'toLat' => (double)$params['toLat'],//目的地纬度
            'toLng' => (double)$params['toLng'],//目的地经度
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

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);

        $total_params = array_merge($config, $personalParams); //合并公共配置
        return $this->request([
            'url' => '/etravel/tob/order/newOrder',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 获取车型预估价
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function getValuation(array $params)
    {
        //非必要字段
        $item = [
            'costId' => 'string', //成本中心Id
            'costType' => 'int', //成本中心类型，0-部门，1-项目
            'estimatedKm' => 'double', //预估里程(单位:m)
            'estimatedTime' => 'int', //预估时间(单位：秒)
            'fixedCode' => 'string', //机场三字码
            'fromAddress' => 'string', //出发地址
            'fromAddressDtl' => 'string', //出发地址详细
            'fromAdCode' => 'string', //出发城市区码：440101
            'orderDays' => 'int', //订单天数
            'payType' => 'string', //支付类型
            'priceType' => 'int', //价格类型 1企业 2散客
            'toAddress' => 'string', //目的地址
            'toAddressDtl' => 'string', //目的地址详细
            'toCityCode' => 'string', //目的城市code
            'toAdCode' => 'string', //目的城市区码：440101
        ];

        //必要字段
        $personalParams = [
            'carModelId' => (string)$params['carModelId'], //车型ID 1:经济型 2:舒适性 3:豪华型 4:商务型 5:出租车
            'expectStartTime' => (int)$params['expectStartTime'], //用车时间 秒级
            'fromCityCode' => (string)$params['fromCityCode'], //出发城市code
            'fromLat' => (double)$params['fromLat'], //出发地纬度
            'fromLng' => (double)$params['fromLng'], //出发地经度
            'prodType' => (string)$params['prodType'], //产品类型 1实时订单 2预约订单 3接机 4送机 5包车租赁
            'toLat' => (double)$params['toLat'], //目的地纬度
            'toLng' => (double)$params['toLng'] //目的地经度
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

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);

        //合并公共配置
        $total_params = array_merge($config,$personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/queryProdPacks',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 订单详情
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function getOrder(array $params)
    {
        //必要字段
        $personalParams = [
            'orderId' => (string)$params['orderId'] //订单ID
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);

        //合并公共配置
        $total_params = array_merge($config,$personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/queryOrderInfo',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 取消订单
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function cancelOrder(array $params)
    {

        //非必要字段
        $item = [
            'cancelAmt' => 'double', //取消费(元)
            'userDev' => 'string' //设备类型，Android 系统:IMEI，iOS 系统: IDFA(无IDFA 则使用IDFV)
        ];

        //必要字段
        $personalParams = [
            'orderId' => (string)$params['orderId'] //订单ID
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


        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/cancelOrder',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 查询用户订单列表
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function getOrderList(array $params)
    {
        //必要字段
        $personalParams = [
            'pageIndex' => (int)$params['pageIndex'], //第几页
            'type' => (string)$params['type'] //查询类型(1全部 2待支付 3待评价 4未完成 5待开票)
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/queryOrderList',
            'method' => 'post'
        ], $total_params);
    }

    /**
     * 获取司机位置
     * @param array $params
     * @return mixed
     * 请求方式 GET application/x-www-form-urlencoded
     */
    public function getDriverLocation(array $params)
    {
        //必要字段
        $personalParams = [
            'orderId' => (string)$params['orderId'], //服务商(如祺出行)订单ID
            'oid' => (string)$params['oid'] //打车平台用户订单ID
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/driver/location',
            'method' => 'get'
        ], $total_params);
    }


    /**
     * 计费规则接口
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function getRule(array $params)
    {
        //非必要字段
        $item = [
            'ruleId' => 'string', //用车制度Id
            'adCode' => 'string', //用车城市区码：440101
            'lat' => 'string', //用车纬度：建议传区码
            'lng' => 'string' //用车经度：建议传区码
        ];

        //必要字段
        $personalParams = [
            'carTypeId' => (int)$params['carTypeId'], //车型
            'cityCode' => (string)$params['cityCode'], //城市编码：440100
            'productTypeId' => (int)$params['productTypeId'], //产品类型(1:实时订单 2:预约订单)
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

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/rule',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 车型费用预估列表
     * @param array $params
     * @return mixed
     * 请求方式 POST application/x-www-form-urlencoded
     */
    public function getEstimateCosts(array $params)
    {
        //非必要字段
        $item = [
            'applyNo' => 'string', //申请单编号
            'costId' => 'string', //成本中心Id
            'costType' => 'int', //成本中心类型，0-部门，1-项目
            'fromAdCode' => 'string', //出发城市区码：440101
            'toAdCode' => 'string', //目的城市区码：440101
        ];

        //必要字段
        $personalParams = [
            'expectStartTime' => (int)$params['expectStartTime'], //用车时间秒级
            'fromCityCode' => (string)$params['fromCityCode'], //出发城市code
            'fromLat' => (double)$params['fromLat'], //出发地纬度
            'fromLng' => (double)$params['fromLng'], //出发地经度
            'prodType' => (int)$params['prodType'], //产品类型 1实时订单 2预约订单 3接机 4送机 5包车租赁
            'sceneId' => (int)$params['sceneId'], //场景id (1:商务用车)
            'toCityCode' => (string)$params['toCityCode'], //目的城市code
            'toLat' => (double)$params['toLat'], //目的地纬度
            'toLng' => (double)$params['toLng']  //目的地经度
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

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/estimateCosts',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 周边车辆汇总信息
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function getAroundSearch(array $params)
    {

        //非必要字段
        $item = [
            'currentDriverInfos' => 'string', //当前已获取到的司机信息集，json格式： key为司机编号，value为已获取到的司机最新定位时间，单位：毫秒。
            'radius' => 'int', //搜索半径，单位：米
        ];


        //必要字段
        $personalParams = [
            'cityCode' => (string)$params['cityCode'], //城市编码
            'latitude' => (double)$params['latitude'], //中心点纬度
            'limit' => (int)$params['limit'], //限制结果数量，最大限制为50个，若超过则只取50。注：若设置了结果数量，则最终返回的结果中包含已获取到的司机（即currentDriverInfos集合中司机
            'longitude' => (double)$params['longitude'], //中心点经度
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
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/lbs/driver/aroundSearch',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 查询取消费
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function getCancelOrderCost(array $params)
    {
        //必要字段
        $personalParams = [
            'orderId' => (string)$params['orderId'], //订单ID
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/cancelOrderCost',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 用户优惠后费用明细
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function getUserCost(array $params)
    {
        //非必要字段
        $item = [
            'couponId' => 'int', //优惠券ID
            'couponName' => 'string', //优惠券名称
            'couponType' => 'int', //优惠券类型
            'couponValue' => 'int', //优惠券面额
            'limitAmount' => 'double', //额度限制
            'limitField' => 'string' //基准费用字段
        ];


        //必要字段
        $personalParams = [
            'orderId' => (string)$params['orderId'], //订单号
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
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/getUserCost',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 申请发票
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function applyInvoice(array $params)
    {

        //非必要字段
        $item = [
            'address' => 'string', //地址
            'bankAccount' => 'string', //开户行账号
            'bankName' => 'string', //开户行
            'invoiceTitle' => 'string', //发票抬头
            'phone' => 'string', //电话
            'remark' => 'string' //备注说明
        ];


        //必要字段
        $personalParams = [
            'email' => (string)$params['email'], //用户邮箱
            'orderIds' => (string)$params['orderIds'],//订单ID，多个用英文逗号分开
            'taxpayerCode' => (string)$params['taxpayerCode'], //纳税人识别号
            'titleType' =>(int)$params['titleType'] //开票类型（企业/个人）, 0：企业 1：个人
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

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/invoice/applyInvoice',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 发票查询
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function queryInvoiceDetail(array $params)
    {
        //必要字段
        $personalParams = [
            'invoiceId' => (int)$params['invoiceId'], //发票ID
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/invoice/queryInvoiceDetail',
            'method' => 'post'
        ], $total_params);
    }

    /**
     * 发票补发
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function resendInvoice(array $params)
    {

        //必要字段
        $personalParams = [
            'email' => (string)$params['email'], //用户邮箱
            'invoiceId' => (int)$params['invoiceId'], //发票ID
            'telephone' => (string)$params['telephone'] //用户电话号码
        ];
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/invoice/resend',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 司机评价
     * @param array $params
     * @return mixed
     * 请求方式  POST application/x-www-form-urlencoded
     */
    public function saveOrderScore(array $params)
    {

        //非必要字段
        $item = [
            'remark' => 'string', //备注
            'tags' => 'array', //标签Id列表
        ];


        //必要字段
        $personalParams = [
            'evaluationScore' => (string)$params['evaluationScore'], //评分: 1-5 分制
            'orderId' => (string)$params['orderId'],//订单ID
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
                if ($value == 'array') {
                    $personalParams[$key] = (array)$params[$key];
                }
            }
        }
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/orderEvaluation',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 支付状态同步
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function getPayStatus(array $params)
    {

        //必要字段
        $personalParams = [
            'partnerOrderId' => (string)$params['partnerOrderId'], //打车平台用户订单ID
            'orderId' => (string)$params['orderId'],//订单ID
            'status' =>(int)$params['status'] //支付状态，0表示失败，1表示成功
        ];
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/pay/status',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 电子围栏接口
     * @param array $params
     * @return mixed
     * GET application/x-www-form-urlencoded
     */
    public function electronicFence(array $params)
    {
        //非必要字段
        $item = [
            'startLon' => 'double', //起点经度
            'startLat' => 'double', //起点纬度
            'endLon' => 'double', //终点经度
            'endLat' => 'double', //终点纬度
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
                if ($value == 'array') {
                    $personalParams[$key] = (array)$params[$key];
                }
            }
        }
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/lbs/electronicfence',
            'method' => 'get'
        ], $total_params);
    }


    /**
     * 司机抢单结果通知(待定)
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function driverGrabCallBack(array $params)
    {
        //必要字段
        $personalParams = [
            'oid' => (string)$params['oid'], //打车平台用户订单ID
            'orderId' => (string)$params['orderId'],//如祺出行订单ID
            'striveStatus' =>(int)$params['striveStatus'], //抢单结果，1-成功，0-失败
            'passengerPhone' => (string)$params['passengerPhone'],//乘客虚拟号，strive_status=1时才需要
            'passengerPhoneSuffix' => (string)$params['passengerPhoneSuffix'] //乘客真实手机号后4位，strive_status=1时才需要
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/strive/callback',
            'method' => 'post'
        ], $total_params);
    }

    /**
     * 显示距离目的地的里程和时间
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function getEta(array $params)
    {
        //必要字段
        $personalParams = [
            'fromLngLatArry' => (string)$params['fromLngLatArry'],//出发坐标集合 [{“lat”: 23.1298,”lng”: 113.352}]
            'toLngLat' => (string)$params['toLngLat'] //目的坐标 {“lat”: 23.1298,”lng”: 113.352}
        ];

        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/lbs/eta',
            'method' => 'post'
        ], $total_params);
    }

    /**
     * 抢单结果回调
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function grabCallBack(array $params)
    {
        //非必要字段
        $item = [
            'oid' => 'string', //融合叫车平台用户订单ID
            'passengerPhone' => 'string', //乘客虚拟号
            'passengerPhoneSuffix' => 'string', //乘客真实手机号后4位
        ];

        //必要字段
        $personalParams=[
            'orderId' => (string)$params['orderId'],//订单ID
            'striveStatus' => (int)$params['striveStatus'] //抢单结果，1-成功，0-失败
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
                if ($value == 'array') {
                    $personalParams[$key] = (array)$params[$key];
                }
            }
        }
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/strive/callback',
            'method' => 'post'
        ], $total_params);
    }


    /**
     * 查询城市列表
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function queryCityList(array $params)
    {
        $personalParams=[];
        //合并公共配置
        //去除config中的enterpriseId和私钥
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        unset($config['enterpriseId']);
        $total_params = array_merge($config,$personalParams);

        return $this->request([
            'url' => '/etravel/tob/product/queryCityList',
            'method' => 'post'
        ], $total_params);
    }

    /**
     * 查询企业订单列表
     * @param array $params
     * @return mixed
     * POST application/x-www-form-urlencoded
     */
    public function pageQuery(array $params)
    {
        //非必要字段
        $item = [
            'pageIndex' => 'int', //当前页码
            'pageSize' => 'int', //每页查询数量（max: 500）
            'orderUserAndPhone' => 'string', //下单人姓名/手机号
            'userAndPhone' => 'String', //乘车人姓名/手机号
            'status' => 'int', //订单支付状态，0-待支付，1-已取消，2-已支付
            'productTypeId' => 'int', //订单类别：1-实时，2-预约
            'refundStatus' => 'int', //退款状态 0 全额退款,1部分退款
            'userDeptId' => 'int', //部门id
            'useType' => 'int',  //用车类型（1：自用车，2：代叫车）
            'payType' => 'int', //订单支付方式，0-交叉支付，1-企业全额支付，2-个人全额支付
            'orderType' => 'int', //订单类型（0：加班出行，1：商务出行，2：审核用车，3：代叫车， -2:自费出行）
            'timePayStart' => 'int', //订单支付开始的时间
            'timePayEnd' => 'int', //订单支付结束的时间
            'timeStart' => 'int', //下单时间开始时间
            'timeEnd' => 'int', //下单时间 结束时间
            'orderEndTimeStart' =>'int',//订单结束的时间-结束日期
            'orderEndTimeEnd'=> 'int' //订单结束的时间-结束日期
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
                if ($value == 'array') {
                    $personalParams[$key] = (array)$params[$key];
                }
            }
        }
        $config=json_decode($this->config, true);
        unset($config['privateKey']);
        //合并公共配置
        $total_params = array_merge($config, $personalParams);
        return $this->request([
            'url' => '/etravel/tob/order/pageQuery',
            'method' => 'post'
        ], $total_params);
    }
}