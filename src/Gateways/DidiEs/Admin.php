<?php
/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Gateways\DidiEs;


use Swimtobird\KuaFuGo\Contracts\AdminGatewayInterface;

class Admin extends AbstractGateway implements AdminGatewayInterface
{
    private function getBaseParams()
    {
        return [
            'client_id'    => $this->config->get('client_id'),
            'access_token' => $this->getAccessToken(),
            'timestamp'    => time(),
            'company_id'   => $this->config->get('company_id')
        ];
    }

    public function getAccessToken()
    {
        $data = [
            'client_id'     => $this->config->get('client_id'),
            'client_secret' => $this->config->get('client_secret'),
            'grant_type'    => 'client_credentials',
            'phone'         => $this->config->get('admin_phone'),
        ];

        return $this->request([
            'url'    => '/river/Auth/authorize',
            'method' => 'post'
        ], $data);
    }

    public function LoginEs(array $params)
    {
        $data = array_merge($this->getBaseParams(), [
        ], $params);

        return $this->request([
            'url'    => '/river/Login/loginES',
            'method' => 'get'
        ], $data);
    }

    public function LoginClient(array $params)
    {
        $data = array_merge($this->getBaseParams(), [
            'app_type' => 2,
        ], $params);

        return $this->request([
            'url'    => '/river/Login/getLoginEncryptStr',
            'method' => 'get'
        ], $data);
    }
}