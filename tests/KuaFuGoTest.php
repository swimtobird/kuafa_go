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

class KuaFuGoTest extends TestCase
{
    public function testRuqi()
    {
        $config = [
            'app_id'            => '123',
            'app_key'        => '10000466938',
        ];

        $go = new GoProvider('Ruqi_Go', $config);

        var_dump($go->getValuation([
            'merchantNo'       => 10000466938,
            'parentMerchantNo' => 10000466938,
        ]));
    }
}