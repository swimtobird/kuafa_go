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
    protected $access_token;

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
        if (isset($this->access_token)){
            return $this->access_token;
        }
        $data = [
            'client_id'     => $this->config->get('client_id'),
            'client_secret' => $this->config->get('client_secret'),
            'timestamp'    => time(),
            'grant_type'    => 'client_credentials',
            'phone'         => $this->config->get('admin_phone'),
        ];

        $data =  $this->request([
            'url'    => '/river/Auth/authorize',
            'method' => 'post'
        ], $data);

        $this->setAccessToken(collect($data)->get('access_token'));

        return $this->access_token;
    }

    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;
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

    public function addBudgetCenter(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/BudgetCenter/add',
            'method' => 'post'
        ], $data);
    }

    public function getBudgetCenter(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/BudgetCenter/get',
            'method' => 'get'
        ], $data);
    }

    public function editBudgetCenter(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/BudgetCenter/edit',
            'method' => 'post'
        ], $data);
    }

    public function delBudgetCenter(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/BudgetCenter/edit',
            'method' => 'del'
        ], $data);
    }

    public function addLegalEntity(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/LegalEntity/add',
            'method' => 'post'
        ], $data);
    }

    public function editLegalEntity(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/LegalEntity/edit',
            'method' => 'post'
        ], $data);
    }

    public function getLegalEntity(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/LegalEntity/get',
            'method' => 'get'
        ], $data);
    }

    public function delLegalEntity(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/LegalEntity/del',
            'method' => 'post'
        ], $data);
    }

    public function addMember(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Member/single',
            'method' => 'post'
        ], $data);
    }

    public function editMember(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Member/edit',
            'method' => 'post'
        ], $data);
    }

    public function getMember(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Member/detail',
            'method' => 'get'
        ], $data);
    }

    public function delMember(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Member/del',
            'method' => 'post'
        ], $data);
    }

    public function listMember(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Member/get',
            'method' => 'get'
        ], $data);
    }

    public function getRole(array $params)
    {
        $data = array_merge($this->getBaseParams(), $params);

        return $this->request([
            'url'    => '/river/Role/get',
            'method' => 'get'
        ], $data);
    }
}