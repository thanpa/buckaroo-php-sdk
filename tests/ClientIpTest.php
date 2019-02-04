<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\ClientIp;

final class ClientIpTest extends TestCase
{
    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedClientIpTypeException
     */
    public function testSetUnsupportedTypeThrowsUnsupportedClientIpTypeException(): void
    {
        $clientIp = new ClientIp();
        $clientIp->setType(2);
    }

    public function testSetType(): void
    {
        $clientIp = new ClientIp();
        $clientIp->setType(ClientIp::TYPE_IPV4);
        $this->assertEquals($clientIp->getType(), ClientIp::TYPE_IPV4);
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidIpAddressException
     */
    public function testSetInvalidAddressThrowsInvalidIpAddressException(): void
    {
        $clientIp = new ClientIp();
        $clientIp->setAddress('2');
    }
}

