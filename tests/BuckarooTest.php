<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;
use Buckaroo\Buckaroo;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class BuckarooTest extends TestCase
{
    public function testExecutes(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)->setMethods(['call', 'getDecodedResponse'])->getMock();
        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode(
                file_get_contents(sprintf('%s/test-responses/ideal-pay-response.json', __DIR__))
            )
        );

        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $tr = (new Transaction())->addService($service)->setAmount(10.00)->setCurrency('EUR')->setInvoice('#0001');

        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient);
        $buckaroo->execute($tr);

        $this->assertEquals($tr->getStatus()->getCode()->getCode(), 791);
        $this->assertEquals($tr->getStatus()->getCode()->getDescription(), 'Pending processing');

        $this->assertNull($tr->getRequiredAction()->getRequestedInformation());
        $this->assertNull($tr->getRequiredAction()->getPayRemainderDetails());
        $this->assertEquals($tr->getRequiredAction()->getName(), 'Redirect');
        $this->assertEquals($tr->getRequiredAction()->getTypeDeprecated(), 0);

        $this->assertEquals(count($tr->getRequestErrors()), 0);
        $this->assertEquals($tr->getServiceCode(), 'ideal');
        $this->assertTrue($tr->getIsTest());
        $this->assertEquals($tr->getTransactionType(), 'C021');
        $this->assertEquals($tr->getMutationType(), 1);
        $this->assertEquals(count($tr->getRelatedTransactions()), 0);
        $this->assertNull($tr->getConsumerMessage());
        $this->assertNull($tr->getOrder());
        $this->assertNull($tr->getIssuingCountry());
        $this->assertFalse($tr->getRecurring());
        $this->assertNull($tr->getCustomerName());
        $this->assertNull($tr->getPayerHash());
    }

    public function testGetsTransaction(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)->setMethods(['call', 'getDecodedResponse'])->getMock();
        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode(
                file_get_contents(sprintf('%s/test-responses/status-response.json', __DIR__))
            )
        );

        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient);
        $tr = $buckaroo->getTransaction('DDD83FAF9505494EBB8987ACCE0AABE4');
        $this->assertEquals($tr->getStatus()->getCode()->getCode(), '190');
        $this->assertEquals($tr->getStatus()->getSubCode()->getCode(), 'S001');
    }

    public function testGetsRefundInfo(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)->setMethods(['call', 'getDecodedResponse'])->getMock();
        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode(
                file_get_contents(sprintf('%s/test-responses/refund-info.json', __DIR__))
            )
        );

        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient);
        $refundInfo = $buckaroo->getRefundInfo('DDD83FAF9505494EBB8987ACCE0AABE4');

        $this->assertEquals($refundInfo->getTransactionKey(), 'DDD83FAF9505494EBB8987ACCE0AABE4');
    }

    public function testPopulatesFromPush(): void
    {
        $body = file_get_contents(sprintf('%s/test-responses/ideal-push.json', __DIR__));

        $buckaroo = new Buckaroo();
        $tr = $buckaroo->populateFromPush($body);
        $this->assertEquals($tr->getKey(), '4E8BD922192746C3918BF4077CXXXXXX');
    }

    public function testSetsApiKeys(): void
    {
        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys('this-is-the-website-key', 'and-this-is-the-secret-key');
        $this->assertEquals('this-is-the-website-key', $buckaroo->getClient()->getWebsiteKey());
        $this->assertEquals('and-this-is-the-secret-key', $buckaroo->getClient()->getSecretKey());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeClientThrowsTypeError(): void
    {
        $buckaroo = new Buckaroo();
        $buckaroo->setClient('InvalidClient');
    }
}
