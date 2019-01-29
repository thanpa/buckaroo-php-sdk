<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class IdealTest extends TestCase
{
    public function testPopulatesParameters(): void
    {
        $service = new Ideal('Pay');
        $service->setIssuer('ABNANL2A');

        $tr = new Transaction();
        $tr->addService($service)->execute();

        $this->assertEquals($service->getConsumerIssuer(), 'ABN AMRO');
        $this->assertEquals($service->getTransactionId(), '0000000000000001');
    }
}

