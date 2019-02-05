<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;
use Buckaroo\Buckaroo;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class TransactionTest extends TestCase
{
    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedServiceException
     */
    public function testAddUnsupportedServiceThrowsUnsupportedServiceException(): void
    {
        $mockedService = $this->getMockBuilder(Ideal::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $mockedService->method('getName')->willReturn('notIdeal');

        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $tr = (new Transaction())->addService($mockedService);

        $buckaroo->setClient($mockedClient)->execute();

        $tr = new Transaction();
        $tr->addService($mockedService);
    }

    /**
     * @expectedException Buckaroo\Exceptions\UndefinedServiceException
     */
    public function testAddUndefinedServiceThrowsUndefinedServiceException(): void
    {
        $mockedService = $this->getMockBuilder(Ideal::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $mockedService->method('getName')->willReturn('');

        $tr = new Transaction();
        $tr->addService($mockedService);
    }

    /**
     * @expectedException Buckaroo\Exceptions\NegativeAmountException
     */
    public function testSetNegativeAmountThrowsNegativeAmountException(): void
    {
        $tr = new Transaction();
        $tr->setAmount(-10);
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidReturnUrlThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrl('invalidUrl');
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidReturnUrlCancelThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlCancel('invalidUrl');
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidReturnUrlErrorThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlError('invalidUrl');
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidReturnUrlRejectThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlReject('invalidUrl');
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidPushUrlThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setPushURL('invalidUrl');
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidPushURLFailureThrowsInvalidUrlException(): void
    {
        $tr = new Transaction();
        $tr->setPushURLFailure('invalidUrl');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeAmountThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setAmount('stringInput');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCurrencyThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setCurrency(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeInvoiceThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setInvoice(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeDescriptionThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setDescription(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeClientIpThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setClientIp('InvalidClientIp');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeReturnUrlThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrl(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeReturnUrlCancelThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlCancel(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeReturnUrlErrorThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlError(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeReturnUrlRejectThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setReturnUrlReject(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeOriginalTransactionKeyThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setOriginalTransactionKey(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeStartRecurrentThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setStartRecurrent(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeContinueOnIncompleteThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setContinueOnIncomplete('stringValue');
    }

    /**
     * @expectedException \TypeError
     */
    public function testAddInvalidTypeServiceThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->addService(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeServicesSelectableByClientThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setServicesSelectableByClient(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeServicesExcludedForClientThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setServicesExcludedForClient(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypePushURLThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setPushURL(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypePushURLFailureThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setPushURLFailure(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeClientUserAgentThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setClientUserAgent(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeOriginalTransactionReferenceThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setOriginalTransactionReference(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCustomParametersThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setCustomParameters('invalidParams');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeAdditionalParametersThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setAdditionalParameters('invalidParams');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeKeyThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setKey(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeStatusThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setStatus('');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRequiredActionThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setRequiredAction('invalidActions');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRequestErrorsThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setRequestErrors(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeServiceCodeThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setServiceCode(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeIsTestThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setIsTest(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeTransactionTypeThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setTransactionType(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeMutationTypeThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setMutationType('invalidMutationType');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRelatedTransactionsThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setRelatedTransactions('invalidMutationType');
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeConsumerMessageThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setConsumerMessage(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeOrderThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setOrder(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeIssuingCountryThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setIssuingCountry(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRecurringThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setRecurring(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCustomerNameThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setCustomerName(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypePayerHashThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setPayerHash(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypePaymentKeyThrowsTypeError(): void
    {
        $tr = new Transaction();
        $tr->setPaymentKey(new \stdClass());
    }
}

