<?php
namespace Buckaroo\Validators;

use Buckaroo\Service\ServiceInterface;
use Buckaroo\Transaction;
use Buckaroo\Transaction\RequiredAction\RequestedInformation;
use Buckaroo\Exceptions\InvalidTransactionAmountException;
use Buckaroo\Exceptions\InvalidTransactionCurrencyException;
use Buckaroo\Exceptions\InvalidTransactionInvoiceException;
use Buckaroo\Exceptions\InvalidTransactionServicesException;
use Buckaroo\Exceptions\InvalidUrlException;
use Buckaroo\Exceptions\UnsupportedRequestedInformationDataTypeException;
use Buckaroo\Exceptions\UnsupportedTransactionMutationTypeException;
use Buckaroo\Exceptions\UnsupportedTransactionContinueOnIncompleteException;

/**
 * Class for validation
 */
class Validator
{
    /**
     * @var Validator
     */
    private $currencyValidator;

    /**
     * Constructor
     *
     * @param ?string $action
     */
    public function __construct()
    {
        $this->currencyValidator = new CurrencyValidator();
        $this->serviceValidator = new ServiceValidator();
    }

    /**
     * Validates the url string.
     *
     * @param string $url
     * @return void
     */
    public function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException();
        }
    }

    /**
     * Validates the service.
     *
     * @param ServiceInterface $service
     * @param Transaction $trancaction
     * @return void
     */
    public function validateService(ServiceInterface $service, Transaction $trancaction): void
    {
        $this->serviceValidator->validateName($service);
        $this->serviceValidator->validateIdealPay($service);
        $this->serviceValidator->validateIdealRefund($service, $trancaction);
    }

    /**
     * Validates the currency string.
     *
     * @param string $currency
     * @return void
     */
    public function validateCurrency(string $currency): void
    {
        $this->currencyValidator->validate($currency);
    }

    /**
     * Validates the requestedInformation data type.
     *
     * @param int $dataType
     * @return void
     */
    public function validateRequestedInformationDataType(int $dataType): void
    {
        if (!in_array($dataType, RequestedInformation::VALID_DATA_TYPES)) {
            throw new UnsupportedRequestedInformationDataTypeException();
        }
    }

    /**
     * Validates the trancaction mutationType data type.
     *
     * @param int $mutationType
     * @return void
     */
    public function validateTrancactionMutationType(int $mutationType): void
    {
        if (!in_array($mutationType, Transaction::VALID_MUTATION_TYPES)) {
            throw new UnsupportedTransactionMutationTypeException();
        }
    }

    /**
     * Validates the trancaction continueOnIncomplete.
     *
     * @param int $continueOnIncomplete
     * @return void
     */
    public function validateTrancactionContinueOnIncomplete(int $continueOnIncomplete): void
    {
        if (!in_array($continueOnIncomplete, Transaction::VALID_CONTINUE_ON_INCOMPLETE_VALUES)) {
            throw new UnsupportedTransactionContinueOnIncompleteException();
        }
    }

    /**
     * Validates the service issuer.
     *
     * @param string $issuer
     * @return void
     */
    public function validateIssuer(string $issuer): void
    {
        $this->serviceValidator->validateIssuer($issuer);
    }

    /**
     * Validates the trancaction.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function validateTransaction(Transaction $transaction): void
    {
        if (empty($transaction->getAmount())) {
            throw new InvalidTransactionAmountException();
        }
        if (empty($transaction->getCurrency())) {
            throw new InvalidTransactionCurrencyException();
        }
        if (empty($transaction->getInvoice())) {
            throw new InvalidTransactionInvoiceException();
        }
        if (empty($transaction->getServices())) {
            throw new InvalidTransactionServicesException();
        }
    }
}
