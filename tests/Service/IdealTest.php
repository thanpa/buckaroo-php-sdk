<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;
use Buckaroo\Buckaroo;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class IdealTest extends TestCase
{
    public function testPay(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)->setMethods(['call', 'getDecodedResponse'])->getMock();
        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode(
                file_get_contents(sprintf('%s/../test-responses/ideal-pay-response.json', __DIR__))
            )
        );

        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');
        $tr = (new Transaction())
            ->addService($service)
            ->setAmount(10.00)
            ->setInvoice('testInvoice')
            ->setCurrency('EUR');
        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient);
        $buckaroo->execute($tr);

        $this->assertEquals($service->getAction(), 'Pay');
        $this->assertEquals($service->getConsumerIssuer(), 'ABN AMRO');
        $this->assertEquals($service->getTransactionId(), '0000000000000001');
    }

    public function testRefund(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)->setMethods(['call', 'getDecodedResponse'])->getMock();
        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode(
                file_get_contents(sprintf('%s/../test-responses/ideal-refund-response.json', __DIR__))
            )
        );

        $service = (new Ideal('Refund'))
            ->setIssuer('ABNANL2A')
            ->setCustomerAccountName('J. de Tèster')
            ->setCustomerIban('NL44RABO0123456789')
            ->setCustomerBic('RABONL2U');
        $tr = (new Transaction())
            ->setOriginalTransactionKey('F996EE747ECD43CDA8851C5F83XXXXXX')
            ->addService($service)
            ->setAmount(5.00)
            ->setInvoice('testRefundInvoice')
            ->setCurrency('EUR');

        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient);
        $buckaroo->execute($tr);

        $this->assertEquals($tr->getStatus()->getCode()->getCode(), '190');
        $this->assertEquals($tr->getStatus()->getSubCode()->getCode(), 'S001');
    }

    public function testGetNameReturnsClassName(): void
    {
        $service = new Ideal('Pay');

        $this->assertEquals('ideal', $service->getName());
    }

    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedIssuerException
     */
    public function testSetInvalidIssuerThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setIssuer('unsupportedIssuer');
    }

    /**
     * @expectedException Buckaroo\Exceptions\UndefinedOriginalKeyForServiceRefundActionException
     */
    public function testSetPayServiceWithUndefinedOriginalTransactionKeThrowsUndefinedOriginalKeyForServiceRefundActionException(): void
    {
        $service = new Ideal('Refund');
        $tr = (new Transaction())->addService($service);
    }

    /**
     * @expectedException Buckaroo\Exceptions\UndefinedIssuerForServicePayActionException
     */
    public function testSetPayServiceWithUndefinedIssuerThrowsUndefinedIssuerForServicePayActionException(): void
    {
        $service = new Ideal('Pay');
        $tr = (new Transaction())->addService($service);
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeIssuerThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setIssuer(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeConsumerIssuerThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setConsumerIssuer(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeTransactionIdThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setTransactionId(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCustomerAccountNameThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setCustomerAccountName(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCustomerIbanThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setCustomerIban(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCustomerBicThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setCustomerBic(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeParametersThrowsTypeError(): void
    {
        $service = new Ideal('Pay');
        $service->setParameters('invalidParameters');
    }

}

