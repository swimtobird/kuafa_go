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

    /**
     * 添加部门/项目
     * @param array $params
     * @return mixed
     */
    public function addBudgetCenter(array $params);

    /**
     * 编辑部门/项目
     * @param array $params
     * @return mixed
     */
    public function editBudgetCenter(array $params);

    /**
     * 删除部门/项目
     * @param array $params
     * @return mixed
     */
    public function delBudgetCenter(array $params);

    /**
     * 查询部门/项目
     * @param array $params
     * @return mixed
     */
    public function getBudgetCenter(array $params);

    /**
     * 添加公司主体
     * @param array $params
     * @return mixed
     */
    public function addLegalEntity(array $params);

    /**
     * 编辑公司主体
     * @param array $params
     * @return mixed
     */
    public function editLegalEntity(array $params);

    /**
     * 删除公司主体
     * @param array $params
     * @return mixed
     */
    public function delLegalEntity(array $params);

    /**
     * 查看公司主体
     * @param array $params
     * @return mixed
     */
    public function getLegalEntity(array $params);


    /**
     * 添加用户
     * @param array $params
     * @return mixed
     */
    public function addMember(array $params);

    /**
     * 编辑用户
     * @param array $params
     * @return mixed
     */
    public function editMember(array $params);

    /**
     * 删除用户
     * @param array $params
     * @return mixed
     */
    public function delMember(array $params);

    /**
     * 查看用户
     * @param array $params
     * @return mixed
     */
    public function getMember(array $params);

    /**
     * 查看用户列表
     * @param array $params
     * @return mixed
     */
    public function listMember(array $params);

    /**
     * 查看角色
     * @param array $params
     * @return mixed
     */
    public function getRole(array $params);
}