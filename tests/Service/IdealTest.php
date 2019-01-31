<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;

final class IdealTest extends TestCase
{
    public function testPay(): void
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

        $this->assertEquals($service->getAction(), 'Pay');
        $this->assertEquals($service->getConsumerIssuer(), 'ABN AMRO');
        $this->assertEquals($service->getTransactionId(), '0000000000000001');
    }

    public function testRefund(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['call'])
            ->getMock();

        $mockedClient->method('call')->willReturn(
            '{
                "Key": "F996EE747ECD43CDA8851C5F83XXXXXX",
                "Status": {
                    "Code": {
                        "Code": 190,
                        "Description": "Success"
                    },
                    "SubCode": {
                        "Code": "S001",
                        "Description": "Transaction successfully processed"
                    },
                    "DateTime": "2017-03-31T09:03:45"
                },
                "RequiredAction": null,
                "Services": [
                    {
                        "Name": "ideal",
                        "Action": null,
                        "Parameters": [
                            {
                                "Name": "customeraccountname",
                                "Value": "J. de Tèster"
                            },
                            {
                                "Name": "CustomerIBAN",
                                "Value": "NL44RABO0123456789"
                            },
                            {
                                "Name": "CustomerBIC",
                                "Value": "RABONL2U"
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
                "AmountCredit": 1,
                "TransactionType": "C121",
                "MutationType": 1,
                "RelatedTransactions": [
                    {
                        "RelationType": "refund",
                        "RelatedTransactionKey": "4E8BD922192746C3918BF4077CXXXXXX"
                    }
                ],
                "ConsumerMessage": null,
                "Order": null,
                "IssuingCountry": null,
                "StartRecurrent": false,
                "Recurring": false,
                "CustomerName": "J. de Tèster",
                "PayerHash": null,
                "PaymentKey": "AE8B6E18A2684846AAAF06A63FXXXXXX"
            }'
        );

        $service = new Ideal('Refund');
        $service->setIssuer('ABNANL2A');

        $tr = new Transaction();
        $tr->setClient($mockedClient);
        $tr->addService($service)->execute();

        $this->assertEquals('Refund', $service->getAction());
        $this->assertEquals('J. de Tèster', $service->getCustomerAccountName());
        $this->assertEquals('NL44RABO0123456789', $service->getCustomerIban());
        $this->assertEquals('RABONL2U', $service->getCustomerBic());
    }
}

