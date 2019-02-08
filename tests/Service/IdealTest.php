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
        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');
        $tr = (new Transaction())
            ->addService($service)
            ->setAmount(10.00)
            ->setInvoice('testInvoice')
            ->setCurrency('EUR');
        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $buckaroo->execute($tr);

        $this->assertEquals($service->getAction(), 'Pay');
        $this->assertEquals($service->getConsumerIssuer(), 'ABN AMRO');
        $this->assertEquals($service->getTransactionId(), '0000000000000001');
    }

    public function testRefund(): void
    {
        $paymentService = (new Ideal('Pay'))->setIssuer('ABNANL2A');
        $trPay = (new Transaction())
            ->addService($paymentService)
            ->setAmount(10.00)
            ->setInvoice('testInvoice')
            ->setCurrency('EUR');
        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $buckaroo->execute($trPay);

        $refundService = (new Ideal('Refund'));
        $trRefund = (new Transaction())
            ->setOriginalTransactionKey($trPay->getPaymentKey())
            ->addService($refundService)
            ->setAmount(5.00)
            ->setInvoice('testRefundInvoice')
            ->setCurrency('EUR');
        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $buckaroo->execute($trRefund);

        $this->assertEquals('Refund', $refundService->getAction());
        $this->assertEquals($trRefund->getStatus()->getCode()->getCode(), '490');
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

