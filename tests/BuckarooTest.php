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
        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $tr = (new Transaction())->addService($service)->setAmount(10.00)->setCurrency('EUR')->setInvoice('#0001');

        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
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
        $service = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $tr = (new Transaction())->addService($service)->setAmount(10.00)->setCurrency('EUR')->setInvoice('#0001');

        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $buckaroo->execute($tr);

        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $tr = $buckaroo->getTransaction($tr->getKey());
        $this->assertEquals($tr->getStatus()->getCode()->getCode(), '791');
    }

    public function testGetsRefundInfo(): void
    {
        $paymentService = (new Ideal('Pay'))->setIssuer('ABNANL2A');

        $paymentTransaction = (new Transaction())->addService($paymentService)->setAmount(10.00)->setCurrency('EUR')->setInvoice('#0001');

        $paymentBuckaroo = new Buckaroo();
        $paymentBuckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $paymentBuckaroo->execute($paymentTransaction);

        $refundService = (new Ideal('Refund'))->setIssuer('ABNANL2A')->setCustomerAccountName('J. de Tèster')->setCustomerIban('NL44RABO0123456789')->setCustomerBic('RABONL2U');
        $refundTransaction = (new Transaction())->setOriginalTransactionKey($paymentTransaction->getKey())->addService($refundService)->setAmount(5.00)->setInvoice('testRefundInvoice')->setCurrency('EUR');
        $refundBuckaroo = new Buckaroo();
        $refundBuckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
        $refundBuckaroo->execute($refundTransaction);

        $refundInfoBuckaroo = new Buckaroo();
        $refundInfo = $refundInfoBuckaroo->getRefundInfo($paymentTransaction->getKey());

        $this->assertEquals($refundInfo->getOriginalTransactionKey(), $paymentTransaction->getKey());
        // more assertions
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
        $buckaroo->setApiKeys(getenv('WEBSITE_KEY'), getenv('SECRET_KEY'));
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
