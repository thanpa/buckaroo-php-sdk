<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class TransactionTest extends TestCase
{
    public function testTransactionExecutes(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['call'])
            ->getMock();

        $mockedClient->method('call')->willReturn(
            '{
                "Key": "4E8BD922192746C3918BF4077CXXXXXX",
                "Status": {
                    "Code": {
                        "Code": 791,
                        "Description": "Pending processing"
                    },
                    "SubCode": {
                        "Code": "S002",
                        "Description": "An additional action is required: RedirectToIdeal"
                    },
                    "DateTime": "2017-03-28T11:23:42"
                },
                "RequiredAction": {
                    "RedirectURL": "https://testcheckout.buckaroo.nl/html/redirect.ashx?r=904A6432D283440ABD4418BF16XXXXXX",
                    "RequestedInformation": null,
                    "PayRemainderDetails": null,
                    "Name": "Redirect",
                    "TypeDeprecated": 0
                },
                "Services": [
                    {
                        "Name": "ideal",
                        "Action": null,
                        "Parameters": [
                            {
                                "Name": "consumerIssuer",
                                "Value": "ABN AMRO"
                            },
                            {
                                "Name": "transactionId",
                                "Value": "0000000000000001"
                            }
                        ]
                    }
                ],
                "CustomParameters": null,
                "AdditionalParameters": null,
                "RequestErrors": null,
                "Invoice": "testinvoice 123",
                "ServiceCode": "ideal",
                "IsTest": true,
                "Currency": "EUR",
                "AmountDebit": 10.0,
                "TransactionType": "C021",
                "MutationType": 1,
                "RelatedTransactions": null,
                "ConsumerMessage": null,
                "Order": null,
                "IssuingCountry": null,
                "StartRecurrent": false,
                "Recurring": false,
                "CustomerName": null,
                "PayerHash": null,
                "PaymentKey": "644545E2409D4223AC09E880ADXXXXXX"
            }'
        );

        $service = new Ideal('Pay');
        $service->setIssuer('ABNANL2A');

        $tr = new Transaction();
        $tr->setClient($mockedClient);
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

    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedPaymentMethodException
     */
    public function testTransactionWithUnsupportedService(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['call'])
            ->getMock();

        $mockedClient->method('call')->willReturn('');

        $mockedService = $this->getMockBuilder(Ideal::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $mockedService->method('getName')->willReturn('notIdeal');

        $tr = new Transaction();
        $tr->setClient($mockedClient);
        $tr->addService($mockedService);
    }

    /**
     * @expectedException Buckaroo\Exceptions\UndefinedPaymentMethodException
     */
    public function testTransactionWithUndefinedService(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['call'])
            ->getMock();

        $mockedClient->method('call')->willReturn('');

        $mockedService = $this->getMockBuilder(Ideal::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $mockedService->method('getName')->willReturn('');

        $tr = new Transaction();
        $tr->setClient($mockedClient);
        $tr->addService($mockedService);
    }

    /**
     * @expectedException \TypeError
     */
    public function testTransactionWithInvalidAmount(): void
    {
        $tr = new Transaction();
        $tr->setAmount('stringInput');
    }

    /**
     * @expectedException Buckaroo\Exceptions\NegativeAmountException
     */
    public function testTransactionWithNegativeAmount(): void
    {
        $tr = new Transaction();
        $tr->setAmount(-10);
    }
}

