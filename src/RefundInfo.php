<?php
namespace Buckaroo;

use Buckaroo\RefundInfo\RefundInputField;
use stdClass;

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
     * @return RefundInfo
     */
    public function populate(stdClass $response): RefundInfo
    {
        $this
            ->setTransactionKey($response->TransactionKey)
            ->setIsRefundable($response->IsRefundable)
            ->setNotRefundableExplanation($response->NotRefundableExplanation)
            ->setAllowPartialRefund($response->AllowPartialRefund)
            ->setMaximumRefundAmount($response->MaximumRefundAmount)
            ->setPendingRefundAmount($response->PendingRefundAmount)
            ->setRefundedAmount($response->RefundedAmount)
            ->setRefundCurrency($response->RefundCurrency)
            ->setServiceCode($response->ServiceCode)
            //->setRefundInputFields($response->RefundInputFields)
            ->setIsCreditmanagement($response->IsCreditmanagement)
            ->setInvoice($response->Invoice)
            ->setInvoiceAmount(isset($response->InvoiceAmount) ? $response->InvoiceAmount : 0)
            ->setInvoiceAmountPaid(isset($response->InvoiceAmountPaid) ? $response->InvoiceAmountPaid : 0)
            ->setInvoiceAmountOpen(isset($response->InvoiceAmountOpen) ? $response->InvoiceAmountOpen : 0)
            ->setCanCreateCreditNote(isset($response->CanCreateCreditNote) ? $response->CanCreateCreditNote : false)
            ->setCreditNoteAmount(isset($response->CreditNoteAmount) ? $response->CreditNoteAmount : 0)
            ->setCanBeCancelled($response->CanBeCancelled)
            ->setUsesBalance($response->UsesBalance)
            ->setAdditionalMessage($response->AdditionalMessage);

        return $this;
    }


    /**
     * TransactionKey getter
     *
     * @return string
     */
    public function getTransactionKey(): string
    {
        return $this->transactionKey;
    }

    /**
     * TransactionKey setter
     *
     * @param string $transactionKey
     *
     * @return self
     */
    public function setTransactionKey(string $transactionKey): RefundInfo
    {
        $this->transactionKey = $transactionKey;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsRefundable(): bool
    {
        return $this->isRefundable;
    }

    /**
     * IsRefundable setter
     *
     * @param boolean $isRefundable
     *
     * @return self
     */
    public function setIsRefundable(bool $isRefundable): RefundInfo
    {
        $this->isRefundable = $isRefundable;

        return $this;
    }

    /**
     * NotRefundableExplanation getter
     *
     * @return string
     */
    public function getNotRefundableExplanation(): string
    {
        return $this->notRefundableExplanation;
    }

    /**
     * NotRefundableExplanation setter
     *
     * @param string $notRefundableExplanation
     *
     * @return self
     */
    public function setNotRefundableExplanation(?string $notRefundableExplanation): RefundInfo
    {
        $this->notRefundableExplanation = $notRefundableExplanation;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAllowPartialRefund(): bool
    {
        return $this->allowPartialRefund;
    }

    /**
     * AllowPartialRefund setter
     *
     * @param boolean $allowPartialRefund
     *
     * @return self
     */
    public function setAllowPartialRefund(bool $allowPartialRefund): RefundInfo
    {
        $this->allowPartialRefund = $allowPartialRefund;

        return $this;
    }

    /**
     * MaximumRefundAmount getter
     *
     * @return float
     */
    public function getMaximumRefundAmount(): float
    {
        return $this->maximumRefundAmount;
    }

    /**
     * MaximumRefundAmount setter
     *
     * @param float $maximumRefundAmount
     *
     * @return self
     */
    public function setMaximumRefundAmount(float $maximumRefundAmount): RefundInfo
    {
        $this->maximumRefundAmount = $maximumRefundAmount;

        return $this;
    }

    /**
     * PendingRefundAmount getter
     *
     * @return float
     */
    public function getPendingRefundAmount(): float
    {
        return $this->pendingRefundAmount;
    }

    /**
     * PendingRefundAmount setter
     *
     * @param float $pendingRefundAmount
     *
     * @return self
     */
    public function setPendingRefundAmount(float $pendingRefundAmount): RefundInfo
    {
        $this->pendingRefundAmount = $pendingRefundAmount;

        return $this;
    }

    /**
     * RefundedAmount getter
     *
     * @return float
     */
    public function getRefundedAmount(): float
    {
        return $this->refundedAmount;
    }

    /**
     * RefundedAmount setter
     *
     * @param float $refundedAmount
     *
     * @return self
     */
    public function setRefundedAmount(float $refundedAmount): RefundInfo
    {
        $this->refundedAmount = $refundedAmount;

        return $this;
    }

    /**
     * RefundCurrency getter
     *
     * @return string
     */
    public function getRefundCurrency(): string
    {
        return $this->refundCurrency;
    }

    /**
     * RefundCurrency setter
     *
     * @param string $refundCurrency
     *
     * @return self
     */
    public function setRefundCurrency(string $refundCurrency): RefundInfo
    {
        $this->refundCurrency = $refundCurrency;

        return $this;
    }

    /**
     * ServiceCode getter
     *
     * @return string
     */
    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    /**
     * ServiceCode setter
     *
     * @param string $serviceCode
     *
     * @return self
     */
    public function setServiceCode(string $serviceCode): RefundInfo
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * RefundInputFields getter
     *
     * @return array
     */
    public function getRefundInputFields(): array
    {
        return $this->refundInputFields;
    }

    /**
     * RefundInputFields setter
     *
     * @param array $refundInputFields
     *
     * @return self
     */
    public function setRefundInputFields(array $refundInputFields): RefundInfo
    {
        $this->refundInputFields = $refundInputFields;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsCreditmanagement(): bool
    {
        return $this->isCreditmanagement;
    }

    /**
     * IsCreditmanagement setter
     *
     * @param boolean $isCreditmanagement
     *
     * @return self
     */
    public function setIsCreditmanagement(bool $isCreditmanagement): RefundInfo
    {
        $this->isCreditmanagement = $isCreditmanagement;

        return $this;
    }

    /**
     * Invoice getter
     *
     * @return string
     */
    public function getInvoice(): string
    {
        return $this->invoice;
    }

    /**
     * Invoice setter
     *
     * @param string $invoice
     *
     * @return self
     */
    public function setInvoice(string $invoice): RefundInfo
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * InvoiceAmount getter
     *
     * @return float
     */
    public function getInvoiceAmount(): float
    {
        return $this->invoiceAmount;
    }

    /**
     * InvoiceAmount setter
     *
     * @param float $invoiceAmount
     *
     * @return self
     */
    public function setInvoiceAmount(float $invoiceAmount): RefundInfo
    {
        $this->invoiceAmount = $invoiceAmount;

        return $this;
    }

    /**
     * InvoiceAmountPaid getter
     *
     * @return float
     */
    public function getInvoiceAmountPaid(): float
    {
        return $this->invoiceAmountPaid;
    }

    /**
     * InvoiceAmountPaid setter
     *
     * @param float $invoiceAmountPaid
     *
     * @return self
     */
    public function setInvoiceAmountPaid(float $invoiceAmountPaid): RefundInfo
    {
        $this->invoiceAmountPaid = $invoiceAmountPaid;

        return $this;
    }

    /**
     * InvoiceAmountOpen getter
     *
     * @return float
     */
    public function getInvoiceAmountOpen(): float
    {
        return $this->invoiceAmountOpen;
    }

    /**
     * InvoiceAmountOpen setter
     *
     * @param float $invoiceAmountOpen
     *
     * @return self
     */
    public function setInvoiceAmountOpen(float $invoiceAmountOpen): RefundInfo
    {
        $this->invoiceAmountOpen = $invoiceAmountOpen;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCanCreateCreditNote(): bool
    {
        return $this->canCreateCreditNote;
    }

    /**
     * CanCreateCreditNote setter
     *
     * @param boolean $canCreateCreditNote
     *
     * @return self
     */
    public function setCanCreateCreditNote(bool $canCreateCreditNote): RefundInfo
    {
        $this->canCreateCreditNote = $canCreateCreditNote;

        return $this;
    }

    /**
     * CreditNoteAmount getter
     *
     * @return float
     */
    public function getCreditNoteAmount(): float
    {
        return $this->creditNoteAmount;
    }

    /**
     * CreditNoteAmount setter
     *
     * @param float $creditNoteAmount
     *
     * @return self
     */
    public function setCreditNoteAmount(float $creditNoteAmount): RefundInfo
    {
        $this->creditNoteAmount = $creditNoteAmount;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCanBeCancelled(): bool
    {
        return $this->canBeCancelled;
    }

    /**
     * CanBeCancelled setter
     *
     * @param boolean $canBeCancelled
     *
     * @return self
     */
    public function setCanBeCancelled(bool $canBeCancelled): RefundInfo
    {
        $this->canBeCancelled = $canBeCancelled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUsesBalance(): bool
    {
        return $this->usesBalance;
    }

    /**
     * UsesBalance setter
     *
     * @param boolean $usesBalance
     *
     * @return self
     */
    public function setUsesBalance(bool $usesBalance): RefundInfo
    {
        $this->usesBalance = $usesBalance;

        return $this;
    }

    /**
     * AdditionalMessage getter
     *
     * @return string
     */
    public function getAdditionalMessage(): string
    {
        return $this->additionalMessage;
    }

    /**
     * AdditionalMessage setter
     *
     * @param string $additionalMessage
     *
     * @return self
     */
    public function setAdditionalMessage(?string $additionalMessage): RefundInfo
    {
        $this->additionalMessage = $additionalMessage;

        return $this;
    }
}
