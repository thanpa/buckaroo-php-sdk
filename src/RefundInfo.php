<?php
namespace Buckaroo;

use Buckaroo\RefundInfo\RefundInputField;

/**
 * This class holds information about a refund, it represents
 * the object that is returned from Buckaroo API.
 */
class RefundInfo
{

    /**
     * @var string
     */
    private $transactionKey = '';

    /**
     * @var boolean
     */
    private $isRefundable = false;

    /**
     * @var string
     */
    private $notRefundableExplanation = '';

    /**
     * @var boolean
     */
    private $allowPartialRefund = false;

    /**
     * @var float
     */
    private $maximumRefundAmount = 0;

    /**
     * @var float
     */
    private $pendingRefundAmount = 0;

    /**
     * @var float
     */
    private $refundedAmount = 0;

    /**
     * @var string
     */
    private $refundCurrency = '';

    /**
     * @var string
     */
    private $serviceCode = '';

    /**
     * @var array
     */
    private $refundInputFields = [];

    /**
     * @var boolean
     */
    private $isCreditmanagement = false;

    /**
     * @var string
     */
    private $invoice = '';

    /**
     * @var float
     */
    private $invoiceAmount = 0;

    /**
     * @var float
     */
    private $invoiceAmountPaid = 0;

    /**
     * @var float
     */
    private $invoiceAmountOpen = 0;

    /**
     * @var boolean
     */
    private $canCreateCreditNote = false;

    /**
     * @var float
     */
    private $creditNoteAmount = 0;

    /**
     * @var boolean
     */
    private $canBeCancelled = false;

    /**
     * @var boolean
     */
    private $usesBalance = false;

    /**
     * @var string
     */
    private $additionalMessage = '';

    /**
     * Populates all fields of the transaction
     *
     * @param stdClass $response
     * @return Transaction
     */
    public function populate(stdClass $response): Transaction
    {
        $this
            ->setServiceData($response->Services)
            ->setKey($response->Key)
            ->setStatus($response->Status)
            ->setRequiredAction(isset($response->RequiredAction) ? $response->RequiredAction : null)
            ->setRequestErrors(isset($response->RequestErrors) ? $response->RequestErrors : null)
            ->setServiceCode($response->ServiceCode)
            ->setIsTest($response->IsTest)
            ->setTransactionType($response->TransactionType)
            ->setMutationType($response->MutationType)
            ->setRelatedTransactions($response->RelatedTransactions)
            ->setConsumerMessage(isset($response->ConsumerMessage) ? $response->ConsumerMessage : null)
            ->setOrder($response->Order)
            ->setIssuingCountry($response->IssuingCountry)
            ->setRecurring($response->Recurring)
            ->setCustomerName($response->CustomerName)
            ->setPayerHash($response->PayerHash)
            ->setPaymentKey($response->PaymentKey);
        return $this;
    }

}
