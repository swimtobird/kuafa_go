<?php

use Swimtobird\KuaFuGo\Contracts\GoGatewayInterface;

/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo;

use Swimtobird\KuaFuGo\Contracts\AdminGatewayInterface;

/**
 * Class GoProvider
 * @package Swimtobird\KuaFuGo
 *
 * @method  AdminGatewayInterface getAccessToken()//获取凭证
 * @method  AdminGatewayInterface LoginEs(array $params) //登录后台
 * @method  AdminGatewayInterface LoginClient(array $params) //登录客户端
 *
 **/
class AdminProvider
{
    use Provider;
}