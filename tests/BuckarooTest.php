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
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['getDecodedResponse', 'call'])
            ->getMock();

        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode('{
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
                "RequestErrors": {
                    "ChannelErrors": [
                      {
                        "Service": "sample string 1",
                        "Action": "sample string 2",
                        "Name": "sample string 3",
                        "Error": "sample string 4",
                        "ErrorMessage": "sample string 5"
                      },
                      {
                        "Service": "sample string 1",
                        "Action": "sample string 2",
                        "Name": "sample string 3",
                        "Error": "sample string 4",
                        "ErrorMessage": "sample string 5"
                      }
                    ],
                    "ServiceErrors": [
                      {
                        "Name": "sample string 1",
                        "Error": "sample string 2",
                        "ErrorMessage": "sample string 3"
                      },
                      {
                        "Name": "sample string 1",
                        "Error": "sample string 2",
                        "ErrorMessage": "sample string 3"
                      }
                    ],
                    "ActionErrors": [
                      {
                        "Service": "sample string 1",
                        "Name": "sample string 2",
                        "Error": "sample string 3",
                        "ErrorMessage": "sample string 4"
                      },
                      {
                        "Service": "sample string 1",
                        "Name": "sample string 2",
                        "Error": "sample string 3",
                        "ErrorMessage": "sample string 4"
                      }
                    ],
                    "ParameterErrors": [
                      {
                        "Service": "sample string 1",
                        "Action": "sample string 2",
                        "Name": "sample string 3",
                        "Error": "sample string 4",
                        "ErrorMessage": "sample string 5"
                      },
                      {
                        "Service": "sample string 1",
                        "Action": "sample string 2",
                        "Name": "sample string 3",
                        "Error": "sample string 4",
                        "ErrorMessage": "sample string 5"
                      }
                    ],
                    "CustomParameterErrors": [
                      {
                        "Name": "sample string 1",
                        "Error": "sample string 2",
                        "ErrorMessage": "sample string 3"
                      },
                      {
                        "Name": "sample string 1",
                        "Error": "sample string 2",
                        "ErrorMessage": "sample string 3"
                      }
                    ]
                },
                "Invoice": "testinvoice 123",
                "ServiceCode": "ideal",
                "IsTest": true,
                "Currency": "EUR",
                "AmountDebit": 10.0,
                "TransactionType": "C021",
                "MutationType": 1,
                "RelatedTransactions": [
                    {
                      "RelationType": "sample string 1",
                      "RelatedTransactionKey": "sample string 2"
                    },
                    {
                      "RelationType": "sample string 1",
                      "RelatedTransactionKey": "sample string 2"
                    }
                ],
                "ConsumerMessage": null,
                "Order": null,
                "IssuingCountry": null,
                "StartRecurrent": false,
                "Recurring": false,
                "CustomerName": null,
                "PayerHash": null,
                "PaymentKey": "644545E2409D4223AC09E880ADXXXXXX"
            }')
        );

        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $tr = (new Transaction())->addService($service);

        $buckaroo = new Buckaroo();
        $buckaroo->setClient($mockedClient)->execute($tr);

        $this->assertEquals($tr->getKey(), '4E8BD922192746C3918BF4077CXXXXXX');
        $this->assertEquals($tr->getStatus()->getCode()->getCode(), 791);
        $this->assertEquals($tr->getStatus()->getCode()->getDescription(), 'Pending processing');

        $this->assertEquals($tr->getRequiredAction()->getRedirectUrl(), 'https://testcheckout.buckaroo.nl/html/redirect.ashx?r=904A6432D283440ABD4418BF16XXXXXX');
        $this->assertNull($tr->getRequiredAction()->getRequestedInformation());
        $this->assertNull($tr->getRequiredAction()->getPayRemainderDetails());
        $this->assertEquals($tr->getRequiredAction()->getName(), 'Redirect');
        $this->assertEquals($tr->getRequiredAction()->getTypeDeprecated(), 0);

        $this->assertEquals(count($tr->getRequestErrors()), 10);
        $this->assertEquals($tr->getServiceCode(), 'ideal');
        $this->assertTrue($tr->getIsTest());
        $this->assertEquals($tr->getTransactionType(), 'C021');
        $this->assertEquals($tr->getMutationType(), 1);
        $this->assertEquals(count($tr->getRelatedTransactions()), 2);
        $this->assertNull($tr->getConsumerMessage());
        $this->assertNull($tr->getOrder());
        $this->assertNull($tr->getIssuingCountry());
        $this->assertFalse($tr->getRecurring());
        $this->assertNull($tr->getCustomerName());
        $this->assertNull($tr->getPayerHash());
        $this->assertEquals($tr->getPaymentKey(), '644545E2409D4223AC09E880ADXXXXXX');
    }

    public function testGetsTransaction(): void
    {
        $mockedClient = $this->getMockBuilder(Client::class)
            ->setMethods(['getDecodedResponse', 'call'])
            ->getMock();

        $mockedClient->method('call')->willReturn($mockedClient);
        $mockedClient->method('getDecodedResponse')->willReturn(
            json_decode('{
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
            }')
        );

        $buckaroo = new Buckaroo();
        $tr = $buckaroo->setClient($mockedClient)->getTransaction('4E8BD922192746C3918BF4077CXXXXXX');
        $this->assertEquals($tr->getStatus()->getCode()->getCode(), '791');
    }

    public function testPopulatesFromPush(): void
    {
        $body = '{
            "Transaction": {
                "Key": "4E8BD922192746C3918BF4077CXXXXXX",
                "Invoice": "testinvoice 123",
                "ServiceCode": "ideal",
                "Status": {
                    "Code": {
                        "Code": 190,
                        "Description": "Success"
                    },
                    "SubCode": {
                        "Code": "S001",
                        "Description": "Transaction successfully processed"
                    },
                    "DateTime": "2017-03-28T11:24:14"
                },
                "IsTest": true,
                "Order": null,
                "Currency": "EUR",
                "AmountDebit": 10.0,
                "TransactionType": "C021",
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
                            },
                            {
                                "Name": "consumerName",
                                "Value": "J. de Tèster"
                            },
                            {
                                "Name": "consumerIBAN",
                                "Value": "NL44RABO0123456789"
                            },
                            {
                                "Name": "consumerBIC",
                                "Value": "RABONL2U"
                            }
                        ],
                        "VersionAsProperty": 2
                    }
                ],
                "CustomParameters": null,
                "AdditionalParameters": null,
                "MutationType": 1,
                "RelatedTransactions": null,
                "IsCancelable": false,
                "IssuingCountry": null,
                "StartRecurrent": false,
                "Recurring": false,
                "CustomerName": "J. de Tèster",
                "PayerHash": "d2e447e9bd91d6e5b4507c2699f2dfa117c60e2e70a13854df4dad57aa54f26785f710b5c6022a9feaf8eace18125f5b1c6929a2ec9a4ff0e88182f9fe085ec3",
                "PaymentKey": "644545E2409D4223AC09E880ADXXXXXX"
            }
        }';

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
