<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\ClientIp;

final class ClientIpTest extends TestCase
{
    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedClientIpTypeException
     */
    public function testClientIpWithUnsupportedType(): void
    {
        $clientIp = new ClientIp();
        $clientIp->setType(2);
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidIpAddressException
     */
    public function testClientIpWithInvalidAddress(): void
    {
        $clientIp = new ClientIp();
        $clientIp->setAddress('2');
    }
}

