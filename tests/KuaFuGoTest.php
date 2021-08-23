<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Tests;


use PHPUnit\Framework\TestCase;
use Swimtobird\KuaFuGo\GoProvider;
use InvalidArgumentException;

class KuaFuGoTest extends TestCase
{

    public function __construct(){
        $privateKey = <<<TEXT
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAKj4f8h8RmABD1PxL8HaFtWEEJJi/QKe/2EaNDGXjEH3KI7PEMNQTY9sVx69D4Nlky21bOdIgevnQV2vM/56WGOWsyTFaUwvb8gLr6XHcHp1Edf5adbNY0pwtcA+119jbjrVdSeZiAzFJHZMj53H8gq/TFiLaVKssm1slqFa3gGRAgMBAAECgYEApehhp5wGiatgvn458zBNbVaf4uxZGyK9BD3zc6Im8HpbE2XTQsNtdF7fZ+og+lZY3e+ev7VdBCFr+C3Ycoz0jTGSdUnk6kCoNWFL3ADrNi0zIg7i7zpzumWrkqw0QCjE77ln9zyJtCuxm0NPugVGuk9KTgg7PIWPv/9kadVtkDECQQDnsAVch8r1pY4JLVFcEfZp4jRcIKqdq1RPNHXX0S/tkTRz25ZUgJu7s4FRSwJZJVLiplANE7ZWLf0QPok569DtAkEAurOsKSbOaRojgKTxnXaSfcOYYzXmtzdEkMlM8w6N5r1Nzm+EqAqX8XDlv7iDhvP2PNl5sa1nqXnSk5nlAAkytQJBAIZDmGfN/c0rOsuQqpR7iFxGDWfSOm2SqxIXaa8+99JpkocNmumvehBlbyyIFn1Ixua30K4zXThGAGBYjTe2s+UCQGOhkATh1ZKWxU1YOCucY+5DG6YN1JH/J1LQaYTnRmhUqxm3vyXhiVXptmEKOP4iYEv2jg94BvKUtP/ZRzAuuGUCQDW5bXKnGn8lh/Yk6EEFWj32BW+hauMVq4XJqZ7jkpmdgAiJBFV0zK/mIgDmLH2UkVXKo4zIzA5YTmEqMxVNPfQ=
TEXT;
        $enterpriseId = 6886288234393894912;
        $config = [
            'loginPhone' => '16666666621',
            'channel' => 'MPTRIP',
            'timestamp' => time(),
            'privateKey' => $privateKey,
            'enterpriseId' => $enterpriseId,
        ];

        $this->go = new GoProvider('Ruqi_Go', $config);
    }

    //测试创建订单
    public function testCreateOrder()
    {
        //TODO:输入结果与返回结果做校验
        $item=$this->go->createOrder([
            'carModelId'=> '1',
            'expectStartTime' =>'1627628846',
            'fromAddress' => '广东省广州市白云机场',
            'fromCityCode' => '440100', //通过获取城市列表接口获得
            'fromLat' => '23.402795',
            'fromLng'=>'113.312146',
            'imei'=> '45435', //可以乱填，但不能为空
            'imsi'=> '3434',  //可以乱填，但不能为空
            'mac' => '23232323', //可以乱填，但不能为空
            'prodType' => '1',
            'sceneId' => '1',
            'toAddress' => '广东省广州市广州塔',
            'toCityCode' => '440100', //通过获取城市列表接口获得
            'toLat' => '23.112223',
            'toLng' => '113.331084',
            'custName'=>'黄俊鹏', //非必须字段测试
            'mobile' =>'15914823991', //非必须字段测试
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试车型预估价
    public function testgetValuation(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getValuation([
            'carModelId'=>'1',
            'expectStartTime' => '1627628846',
            'fromCityCode' => '440100',
            'fromLat'=> '23.402795',
            'fromLng'=> '113.312146',
            'prodType'=> '1',
            'toLat' => '23.112223',
            'toLng' => '113.331084',
            'orderDays'=> '3',//非必须字段测试
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    //测试获取订单详情
    public function testgetOrder(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getOrder([
            'orderId'=>'6990994287680815604',
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    //测试取消订单
    public function testcancelOrder(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->cancelOrder([
            'orderId'=>'6990994287680815604',
            'cancelAmt'=>'20',
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    //测试获取订单列表
    public function testgetOrderList(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getOrderList([
            'pageIndex'=>'1',
            'type'=>'1',
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试获取司机位置
    public function testgetDriverLocation(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getDriverLocation([
            'orderId'=>'6979778461422322852',
            'oid'=>'23123131231313',
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    //测试计费规则接口
    public function testgetrule(){
        $item=$this->go->getRule([
            'carTypeId'=>'1',
            'cityCode'=>'440100',
            'productTypeId'=>'1',
            'adCode'=>'440100',//非必要字段测试
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试车型费用预估列表
    public function testgetEstimateCosts(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getEstimateCosts([
            'expectStartTime'=>'1627628846',
            'fromCityCode'=>'440100',
            'fromLat'=>'23.402795',
            'fromLng'=>'113.312146',
            'prodType'=>'1',
            'sceneId'=>'1',
            'toCityCode'=>'440100',
            'toLat'=>'23.112223',
            'toLng'=>'113.331084'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试周边车辆汇总信息
    public function testaroundsearch(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getAroundSearch([
            'cityCode'=>'440100',
            'latitude'=> '23.402795',
            'limit' => '5',
            'longitude'=>'113.312146',
            'radius'=>'1000000' //非必选字段测试
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试查询取消费
    public function testCancelOrderCost(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getCancelOrderCost([
            'orderId'=>'6979778461422322852',
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试用户优惠后费用明细
    public function testgetUserCost(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getUserCost([
            'orderId'=>'6979778461422322852',
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }

    //测试申请发票
    public function testapplyInvoice(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->applyInvoice([
            'email'=>'1309068574@qq.com',
            'orderIds' => '[6966488276773371978]',
            'taxpayerCode'=>'123456',
            'titleType'=>'2',
            'phone'=>'13539833670'//非必选字段测试
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试发票查询
    public function testqueryInvoiceDetail(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->queryInvoiceDetail([
           'invoiceId'=>'123'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试发票补发
    public function testresendInvoice(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->resendInvoice([
            'email'=>'1309068574@qq.com',
            'invoiceId'=>'123',
            'telephone'=>'13539833670'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试司机评价
    public function testorderEvaluation(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->saveOrderScore([
            'evaluationScore'=>'5',
            'orderId'=>'6979778461422322852',
            'remark'=>'测试'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试同步支付状态
    public function testgetPayStatus(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->getPayStatus([
            'partnerOrderId'=>'8008208820',
            'orderId'=>'6991012652960973306',
            'status'=>'1'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试电子电子围栏接口
    public function testelectronicFence(){
        //TODO:输入结果与返回结果做校验
        $item=$this->go->electronicFence([
        ]);

    }

    //测试显示距离目的地的里程和时间
    public function testgeteta(){
        $item=$this->go->getEta([
            'fromLngLatArry'=>'{“lat”: 23.1298,”lng”: 113.352}',
            'toLngLat' => '{“lat”: 23.1298,”lng”: 113.352}'
        ]);
    }

    //测试抢单结果回调
    public function testgrabCallBack(){
        $item=$this->go->grabCallBack([
            'orderId'=>'6991012652960973306',
            'striveStatus' => '1'
        ]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException("[".$item['code']."]".$item['message']);
        }
    }


    //测试获取城市列表
    public function testqueryCityList()
    {
        //TODO:输入结果与返回结果做校验
        //只需要公共参数即可查询
        $item=$this->go->queryCityList([]);
        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException($item['message']);
        }
    }

    //测试查询企业订单列表
    public function testpageQuery(){
        //TODO:输入结果与返回结果做校验
        //只需要公共参数即可查询
        $item=$this->go->pageQuery([
            'pageIndex'=>'1'
        ]);

        //TODO:验证异常参数情况
        if ($item['code']!==10000) {
            throw new InvalidArgumentException($item['message']);
        }
    }

}