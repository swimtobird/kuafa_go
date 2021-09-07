<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-31
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Tests;


use PHPUnit\Framework\TestCase;
use Swimtobird\KuaFuGo\GoProvider;
use InvalidArgumentException;

class T3Test extends TestCase
{

    public function __construct(){
        //公共参数
        $config = [
            'channel' => '',
            'timestamp' => time(),
            'token' => ''
        ];

        $this->go = new GoProvider('T3_Go', $config);
    }

    //测试获取订单详情
    public function testSaveOrderComplaint(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->saveOrderComplaint([
            'platformOrderNo' => 'KC120210828182400001',
            'tripartiteOrderId' => 'PT2021082851555250',
            'complaintReason' => 1,
            'description' => '无',
            'complaintType' => 0
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testGetPriceDesc(){
        $item=$this->go->getPriceDesc([]);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testGetOpenCity(){
        $item=$this->go->getOpenCity();
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testNearByCar(){
        $data = array(
            'cityCode' => '0757',
            'longitude' => 113.225918,
            'latitude' => 22.937863,
        );
        $item=$this->go->getNearByCar($data);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testGetCityRules(){
        $data = [
            'cityCode' => '0757', //城市编码(行政编码)
            'vehicleType' => 1, //车辆类型
            'typeTime' => 1, //用车类型（1 实时 2 预约）
        ];
        $item=$this->go->getCityRules($data);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testCreateOrder(){
        $data = [
            'tripartiteOrderId' => date('Ymdhis'), //第三方订单ID
            'startLocationLng' => 113.225918,//出发地经度
            'startLocationLat' => 22.937863,//出发地纬度
            'startName' => '怡和中心',//出发地名称
            'endLocationLng' => 113.216523,//目的地经度
            'endLocationLat' => 22.91303,//目的地纬度
            'endName' => '美的全球创新中心',//目的地名称
            'typeTime' => 1,//订单类型（时效性）：1 实时订单， 2 预约订单
            'typeModule' => 4,//产品类型
            'vehicleType' => 1,//车辆等级
            'estimateFlag' => 'd2b92d9e74bb4a1cb7181a538a0a973f',//预估价格标识
            'passengerPhone' => 18924856510,//乘客手机号
            'tripartitePassengerId' => 245,//第三方用户唯一ID
        ];
//        $item=$this->go->createOrder($data);
//        var_dump($item,$data['tripartiteOrderId']);
//        if ($item['code']!==10000) {
//            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
//        }
    }

    public function testGetValuation(){
        $data = [
            'startLocationLng' => 113.225918, //出发地经度
            'startLocationLat' => 22.937863, //出发地纬度
            'endLocationLng' => 113.216523, //目的地经度
            'endLocationLat' => 22.91303, //目的地纬度
            'typeTime' => 1,//订单类型（时效性）：1 实时订单， 2 预约订单
            'typeModule' => 4, //产品类型
            "vehicleTypes" => "1", //车辆等级，多个车辆等级以半角逗号分隔
        ];
        $item=$this->go->getValuation($data);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testGetOrder(){
        $data = [
            'platformOrderNo' => 'TS120210823134500002', //平台订单号
            'tripartiteOrderId' => '20210823014548', //第三方订单ID
        ];
        $item=$this->go->getOrder($data);
        var_dump($item);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testCancelOrder(){
        $data = [
            'platformOrderNo' => 'TS120210823134500002', //平台订单号
            'tripartiteOrderId' => '20210823014548', //第三方订单ID
        ];
//        $item=$this->go->cancelOrder($data);
//        var_dump($item);
//        if ($item['code']!==10000) {
//            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
//        }
    }

    public function testGetDriverLocation(){
        $data = [
            'platformOrderNo' => 'TS120210823134500002',
        ];
        $item=$this->go->getDriverLocation($data);
        var_dump($item);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testGetOrderStatusNotify(){
        $data = [
            'platformOrderNo' => 'TS120210823134500002',
        ];
        $item=$this->go->getOrderStatusNotify($data);
        var_dump($item);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    public function testSaveOrderScore(){
        $data = [
            'platformOrderNo' => 'TS120210823134500002', //平台订单号(T3)
            'evaluateType' => 1, //评价类型：1司机2平台3车辆4司机评价乘客
            'addType' => 1, //评价类型：1原始评价2追加评价
            'score' => 5, //评分（最高5分）
            'comment' => '好' //评价内容
        ];
        $item=$this->go->getOrderStatusNotify($data);
        var_dump($item);
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }
}
