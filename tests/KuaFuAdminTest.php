<?php
/**
 *
 * User: swimtobird
 * Date: 2022-08-04
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird\KuaFuGo\Tests;


use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Swimtobird\KuaFuGo\AdminProvider;

class KuaFuAdminTest extends TestCase
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var AdminProvider
     */
    private $adminProvider;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = [
            'client_id' => $_ENV['DIDIES_CLIENT_ID'],
            'client_secret' => $_ENV['DIDIES_CLIENT_SECRET'],
            'sign_key' => $_ENV['DIDIES_SIGN_KEY'],
            'company_id' => $_ENV['DIDIES_COMPANY_ID'],
            'admin_phone' => $_ENV['DIDIES_ADMIN_PHONE'],
        ];

        $this->adminProvider = new AdminProvider('DidiEs_Admin', $this->config);
    }

    public function testGetAccessToken()
    {
//        var_dump($this->adminProvider->getAccessToken());die;
    }

    public function testLoginEs()
    {
        var_dump($this->adminProvider->LoginEs(['phone' => $_ENV['DIDIES_CLIENT_PHONE']]));
    }

    public function testLoginClient()
    {

        var_dump($this->adminProvider->LoginClient(['phone' => $_ENV['DIDIES_CLIENT_PHONE']]));
    }
}