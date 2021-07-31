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

    public function testRsa()
    {
        $demo_string = 'a=1&app_id=1&b=2&timestamp=1552274633';

        $signature = '';

        $privateKey = <<<TEXT
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMHpxwUNH3UQcv50 rKMHCcJFwfJQBqCumy1+hoVr7wYbt0XRvQJ2v/oOCKXFpD5Nb1kJhIKN+aOryVgh V+af2Y06ZirxIHaRt4UbrW4OqqBgJtjzaJ8yo/SoMY83A7+ctjKfUYeWgQTAaoij 3cw+CbweLV5c6AGgRxvrDTEyW8dhAgMBAAECgYAJbUYBltu6oywT9rQV0NfGnAGL uBw6X4KnuYjsn4ylLV/Bgyq/HerDSz9cX7lWVglduLq6ZhCGxmkpYaWWTpsSzsRl W0yb1PkJmbboSWW0aQ87Rm/Tvk/dZ5cGSWOzC/sXOgQonUbPU0la7fwM3yMIQoXY +k8jNBpWdtGCIRIByQJBAPf/c0ZLvYyG8QWTIDYQjbYPeA/YsJsaUMLCpx2Y5yp5 ndOttFRX3IeGOPYcMXwNSJ7+nJJD8BV7ngmVnKZ7bpcCQQDIK5Ga7JOcLkhVs0sW 9JBu+zqB7Uk3oSAp27ZopSVJunm1WgMIWpr03BkXvdbtD/HYXT2FNTj5t4Tb2D9T x7DHAkEAqcMF5/Lk+BNPXd+OxzOhriT8rOxKSIJFEm0o9Iu8gkjqDwLzVGEopuTs jRxTi3WUZrIn/7/d0vbiAfGWYChSVQJAQRTJVpGsvI7fvd15gJErlKniL/QyZf/h MTraZ9Op9/rFL42AhurOjuYw0mNKyfDxNOO76N+REr/0VnZMwLSgaQJBALsPFVqX fy90CE/RFjuqGm3NS9vOmJDkhlzVDMT+JunrH+BLqpQJvqkkM/gXebQDgUhrp4Ab
Vyqog8xcJMhx/Es=
TEXT;

        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        $key = openssl_get_privatekey($privateKey);

        openssl_sign($demo_string, $signature, $key,OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        var_dump(base64_encode($signature));
    }


    public function testSign()
    {
        $data = 'a=1&app_id=1&b=2&timestamp=1552274633';

        $sign = 'F3vEQPFPIGWr+nBca/lYgJEUfybL6+zIn7XFcTjM2QY4aJzEo9AxdoXDxhsD7MvjO9HLQq5OwSYTITe5SBUXU5h3KVlCsQX6v9pFlSGCDuDtIsX4kFkYMHjGjTUWywTWbFd4BAW06FKhUpfSWvA1pkpaqGcsXs1i2oKN4mNduY8=';

        $pubKey = <<<TEXT
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDB6ccFDR91EHL+dKyjBwnCRcHy UAagrpstfoaFa+8GG7dF0b0Cdr/6DgilxaQ+TW9ZCYSCjfmjq8lYIVfmn9mNOmYq 8SB2kbeFG61uDqqgYCbY82ifMqP0qDGPNwO/nLYyn1GHloEEwGqIo93MPgm8Hi1e
XOgBoEcb6w0xMlvHYQIDAQAB
TEXT;
        $sign = base64_decode($sign);

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $key = openssl_pkey_get_public($pubKey);
        $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;

        var_dump($result);
    }
}