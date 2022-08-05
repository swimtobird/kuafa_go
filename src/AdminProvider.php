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
 * Class AdminProvider
 * @package Swimtobird\KuaFuGo
 *
 * @method  AdminGatewayInterface getAccessToken()//获取凭证
 * @method  AdminGatewayInterface LoginEs(array $params) //登录后台
 * @method  AdminGatewayInterface LoginClient(array $params) //登录客户端
 * @method  AdminGatewayInterface addBudgetCenter(array $params) //添加部门/项目
 * @method  AdminGatewayInterface editBudgetCenter(array $params) //编辑部门/项目
 * @method  AdminGatewayInterface delBudgetCenter(array $params) //删除部门/项目
 * @method  AdminGatewayInterface getBudgetCenter(array $params) //查询部门/项目
 * @method  AdminGatewayInterface addLegalEntity(array $params) //添加公司主体
 * @method  AdminGatewayInterface editLegalEntity(array $params) //编辑公司主体
 * @method  AdminGatewayInterface delLegalEntity(array $params) //删除公司主体
 * @method  AdminGatewayInterface getLegalEntity(array $params) //查看公司主体
 * @method  AdminGatewayInterface addMember(array $params) //添加用户
 * @method  AdminGatewayInterface editMember(array $params) //编辑用户
 * @method  AdminGatewayInterface delMember(array $params) //删除用户
 * @method  AdminGatewayInterface getMember(array $params) //获取用户
 * @method  AdminGatewayInterface listMember(array $params) //获取用户列表
 * @method  AdminGatewayInterface getRole(array $params) //查看角色
 *
 **/
class AdminProvider
{
    use Provider;
}