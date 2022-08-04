<?php
/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Contracts;


interface AdminGatewayInterface
{
    /**
     * 获取凭证
     * @return mixed
     */
    public function getAccessToken();
    /**
     * 登录后台
     * @param array $params
     * @return mixed
     */
    public function LoginEs(array $params);

    /**
     * 登录客户端
     * @param array $params
     * @return mixed
     */
    public function LoginClient(array $params);
}