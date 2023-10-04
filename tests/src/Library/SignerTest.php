<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Common\Tests\Library;

use Paytic\Omnipay\Common\Library\Signer;
use Paytic\Omnipay\Common\Tests\AbstractTest;

/**
 * Class SignerTest
 * @package Paytic\Omnipay\Common\Tests\Library
 */
class SignerTest extends AbstractTest
{
    public function testConvert()
    {
        $key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';

        $signer = new Signer();
        $key = $signer->convertKey($key, Signer::KEY_TYPE_PUBLIC);

        static::assertEquals('-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRA
FljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQE
B/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5Ksi
NG9zpgmLCUYuLkxpLQIDAQAB
-----END PUBLIC KEY-----', $key);
    }

    public function testSealContentWithRSA()
    {
        $content = 'test';
        $signer = new Signer();
        $signer->setCertificate(file_get_contents(TEST_FIXTURE_PATH . '/ssl/keys/mobilpay_certificate.cert'));

        $result = $signer->sealContentWithRSA($content);

        static::assertCount(2, $result);
        static::assertIsString($result[0]);
        static::assertIsArray($result[1]);
    }
}
