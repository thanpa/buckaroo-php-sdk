<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class TransactionTest extends TestCase
{
    public function testTransactionExecutes(): void
    {
        $service = new Ideal('Pay');
        $service->setIssuer('ABNANL2A');

        $tr = new Transaction();
        $tr->addService($service)->execute();

        $this->assertEquals($tr->getKey(), '4E8BD922192746C3918BF4077CXXXXXX');
        $this->assertEquals($tr->getStatus()->getCode()->getCode(), 791);
        $this->assertEquals($tr->getStatus()->getCode()->getDescription(), 'Pending processing');
    }
}

