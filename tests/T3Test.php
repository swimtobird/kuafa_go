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
            'channel' => 'mp',
            'timestamp' => time(),
            'token' => '8299e163c1c2463ebe9523652f869055'
        ];

        $this->go = new GoProvider('T3_Go', $config);
    }

    public function test(){

    }

}
