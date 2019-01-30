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

        $this->assertEquals($tr->getRequiredAction()->getRedirectUrl(), 'https://testcheckout.buckaroo.nl/html/redirect.ashx?r=904A6432D283440ABD4418BF16XXXXXX');
        $this->assertNull($tr->getRequiredAction()->getRequestedInformation());
        $this->assertNull($tr->getRequiredAction()->getPayRemainderDetails());
        $this->assertEquals($tr->getRequiredAction()->getName(), 'Redirect');
        $this->assertEquals($tr->getRequiredAction()->getTypeDeprecated(), 0);

        $this->assertNull($tr->getRequestErrors());
        $this->assertEquals($tr->getServiceCode(), 'ideal');
        $this->assertTrue($tr->getIsTest());
        $this->assertEquals($tr->getTransactionType(), 'C021');
        $this->assertEquals($tr->getMutationType(), 1);
        $this->assertNull($tr->getRelatedTransactions());
        $this->assertNull($tr->getConsumerMessage());
        $this->assertNull($tr->getOrder());
        $this->assertNull($tr->getIssuingCountry());
        $this->assertFalse($tr->getRecurring());
        $this->assertNull($tr->getCustomerName());
        $this->assertNull($tr->getPayerHash());
        $this->assertEquals($tr->getPaymentKey(), '644545E2409D4223AC09E880ADXXXXXX');
    }
}

