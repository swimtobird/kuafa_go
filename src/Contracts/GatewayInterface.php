<?php
/**
 *
 * User: swimtobird
 * Date: 2021-07-29
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Contracts;


use Swimtobird\KuaFuGo\Utils\Config;

interface GatewayInterface
{
    public function __construct(Config $config);

}