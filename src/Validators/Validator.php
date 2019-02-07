<?php
namespace Buckaroo\Validators;

use Buckaroo\Service\ServiceInterface;
use Buckaroo\Service\ServiceAbstract;
use Buckaroo\Transaction;
use Buckaroo\Transaction\RequiredAction\RequestedInformation;
use Buckaroo\Exceptions\InvalidUrlException;
use Buckaroo\Exceptions\UnsupportedServiceException;
use Buckaroo\Exceptions\UndefinedServiceException;
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
     * @return void
     */
    public function validateService(ServiceInterface $service): void
    {
        if (empty($service->getName())) {
            throw new UndefinedServiceException();
        }
        $declaredServices = ServiceAbstract::getDeclaredServices();
        if (!in_array($service->getName(), array_keys($declaredServices))) {
            throw new UnsupportedServiceException();
        }
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
}
