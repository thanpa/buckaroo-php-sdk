<?php
namespace Buckaroo;

use Buckaroo\Exceptions\UnsupportedPaymentMethodException;
use Buckaroo\Exceptions\UndefinedPaymentMethodException;
use Buckaroo\Service\ServiceInterface;
use Buckaroo\Transaction\ClientIp;
use Buckaroo\Transaction\Status;
use Buckaroo\Transaction\RequiredAction;
use Buckaroo\Transaction\Status\Code;
use DateTime;
use stdClass;

/**
 * This class holds information about the transaction. The information is
 * for both request and response data. The execution of the transaction
 * uses the request data to set the response data.
 */
class Transaction
{
    const VALID_SERVICES = ['ideal'];

    /**
     * @var string
     */
    private $currency = '';

    /**
     * @var int
     */
    private $amount = 0;

    /**
     * @var string
     */
    private $invoice = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var ClientIp
     */
    private $clientIp;

    /**
     * @var string
     */
    private $returnUrl = '';

    /**
     * @var string
     */
    private $returnUrlCancel = '';

    /**
     * @var string
     */
    private $returnUrlError = '';

    /**
     * @var string
     */
    private $returnUrlReject = '';

    /**
     * @var string
     */
    private $originalTransactionKey = '';

    /**
     * @var bool
     */
    private $startRecurrent = false;

    /**
     * @var string
     */
    private $continueOnIncomplete = 'No';

    /**
     * @var array
     */
    private $services = [];

    /**
     * @var string
     */
    private $servicesSelectableByClient = '';

    /**
     * @var string
     */
    private $servicesExcludedForClient = '';

    /**
     * @var string
     */
    private $pushURL = '';

    /**
     * @var string
     */
    private $pushURLFailure = '';

    /**
     * @var string
     */
    private $clientUserAgent = '';

    /**
     * @var string
     */
    private $originalTransactionReference = '';

    /**
     * @var array
     */
    private $customParameters = [];

    /**
     * @var array
     */
    private $additionalParameters = [];

    /**
     * @var string
     */
    private $key = '';

    /**
     * @var Status
     */
    private $status;

    /**
     * @var RequiredAction
     */
    private $requiredAction;

    /**
     * @var string
     */
    private $requestErrors = null;

    /**
     * @var string
     */
    private $serviceCode = '';

    /**
     * @var bool
     */
    private $isTest = true;

    /**
     * @var string
     */
    private $transactionType = '';

    /**
     * @var int
     */
    private $mutationType = 1;

    /**
     * @var array
     */
    private $relatedTransactions = null;

    /**
     * @var string
     */
    private $consumerMessage = null;

    /**
     * @var string
     */
    private $order = null;

    /**
     * @var string
     */
    private $issuingCountry = null;

    /**
     * @var bool
     */
    private $recurring = false;

    /**
     * @var string
     */
    private $customerName = null;

    /**
     * @var string
     */
    private $payerHash = null;

    /**
     * @var string
     */
    private $paymentKey = '';

    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Client setter.
     *
     * @param ClientInterface $client
     * @return Transaction
     */
    public function setClient(ClientInterface $client): Transaction
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Currency setter.
     *
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency(string $currency): Transaction
    {
        // Filter valid currency
        $this->currency = $currency;

        return $this;
    }

    /**
     * Currency getter.
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Amount setter.
     *
     * @param float $amount
     * @return Transaction
     */
    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Amount getter.
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Invoice setter.
     *
     * @param string $invoice
     * @return Transaction
     */
    public function setInvoice(string $invoice): Transaction
    {
        // Filter printable characters
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Invoice getter.
     *
     * @return string
     */
    public function getInvoice(): string
    {
        return $this->invoice;
    }

    /**
     * Description setter.
     *
     * @param string $description
     * @return Transaction
     */
    public function setDescription(string $description): Transaction
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * ClientIp setter.
     *
     * @param ClientIp $clientIp
     * @return Transaction
     */
    public function setClientIp(ClientIp $clientIp): Transaction
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    /**
     * ClientIp getter.
     *
     * @return ClientIp
     */
    public function getClientIp(): ClientIp
    {
        return $this->clientIp;
    }

    /**
     * ReturnUrl setter.
     *
     * @param string $returnUrl
     * @return Transaction
     */
    public function setReturnUrl(string $returnUrl): Transaction
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * ReturnUrl getter.
     *
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    /**
     * ReturnUrlCancel setter.
     *
     * @param string $returnUrlCancel
     * @return Transaction
     */
    public function setReturnUrlCancel(string $returnUrlCancel): Transaction
    {
        $this->returnUrlCancel = $returnUrlCancel;

        return $this;
    }

    /**
     * ReturnUrlCancel getter.
     *
     * @return string
     */
    public function getReturnUrlCancel(): string
    {
        return $this->returnUrlCancel;
    }

    /**
     * ReturnUrlError setter.
     *
     * @param string $returnUrlError
     * @return Transaction
     */
    public function setReturnUrlError(string $returnUrlError): Transaction
    {
        $this->returnUrlError = $returnUrlError;

        return $this;
    }

    /**
     * ReturnUrlError getter.
     *
     * @return string
     */
    public function getReturnUrlError(): string
    {
        return $this->returnUrlError;
    }

    /**
     * ReturnUrlReject setter.
     *
     * @param string $returnUrlReject
     * @return Transaction
     */
    public function setReturnUrlReject(string $returnUrlReject): Transaction
    {
        $this->returnUrlReject = $returnUrlReject;

        return $this;
    }

    /**
     * ReturnUrlReject getter.
     *
     * @return string
     */
    public function getReturnUrlReject(): string
    {
        return $this->returnUrlReject;
    }

    /**
     * OriginalTransactionKey setter.
     *
     * @param string $originalTransactionKey
     * @return Transaction
     */
    public function setOriginalTransactionKey(string $originalTransactionKey): Transaction
    {
        $this->originalTransactionKey = $originalTransactionKey;

        return $this;
    }

    /**
     * OriginalTransactionKey getter.
     *
     * @return string
     */
    public function getOriginalTransactionKey(): string
    {
        return $this->originalTransactionKey;
    }

    /**
     * StartRecurrent setter.
     *
     * @param bool $startRecurrent
     * @return Transaction
     */
    public function setStartRecurrent(bool $startRecurrent): Transaction
    {
        $this->startRecurrent = $startRecurrent;

        return $this;
    }

    /**
     * StartRecurrent getter.
     *
     * @return bool
     */
    public function getStartRecurrent(): bool
    {
        return $this->startRecurrent;
    }

    /**
     * ContinueOnIncomplete setter.
     *
     * @param string $continueOnIncomplete
     * @return Transaction
     */
    public function setContinueOnIncomplete(string $continueOnIncomplete): Transaction
    {
        $this->continueOnIncomplete = $continueOnIncomplete;

        return $this;
    }

    /**
     * ContinueOnIncomplete getter.
     *
     * @return string
     */
    public function getContinueOnIncomplete(): string
    {
        return $this->continueOnIncomplete;
    }

    /**
     * Service add.
     *
     * @param ServiceInterface $service
     * @return Transaction
     */
    public function addService(ServiceInterface $service): Transaction
    {
        if (!in_array($service->getName(), self::VALID_SERVICES)) {
            throw new UnsupportedPaymentMethodException();
        }
        $this->services[$service->getName()] = $service;

        return $this;
    }

    /**
     * Service getter.
     *
     * @return ServiceInterface
     */
    public function getService(string $name): ServiceInterface
    {
        return $this->services[$name];
    }

    /**
     * Services getter.
     *
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * ServicesSelectableByClient setter.
     *
     * @param string $servicesSelectableByClient
     * @return Transaction
     */
    public function setServicesSelectableByClient(string $servicesSelectableByClient): Transaction
    {
        $this->servicesSelectableByClient = $servicesSelectableByClient;

        return $this;
    }

    /**
     * ServicesSelectableByClient getter.
     *
     * @return string
     */
    public function getServicesSelectableByClient(): string
    {
        return $this->servicesSelectableByClient;
    }

    /**
     * ServicesExcludedForClient setter.
     *
     * @param string $servicesExcludedForClient
     * @return Transaction
     */
    public function setServicesExcludedForClient(string $servicesExcludedForClient): Transaction
    {
        $this->servicesExcludedForClient = $servicesExcludedForClient;

        return $this;
    }

    /**
     * ServicesExcludedForClient getter.
     *
     * @return string
     */
    public function getServicesExcludedForClient(): string
    {
        return $this->servicesExcludedForClient;
    }

    /**
     * PushURL setter.
     *
     * @param string $pushURL
     * @return Transaction
     */
    public function setPushURL(string $pushURL): Transaction
    {
        $this->pushURL = $pushURL;

        return $this;
    }

    /**
     * PushURL getter.
     *
     * @return string
     */
    public function getPushURL(): string
    {
        return $this->pushURL;
    }

    /**
     * PushURLFailure setter.
     *
     * @param string $pushURLFailure
     * @return Transaction
     */
    public function setPushURLFailure(string $pushURLFailure): Transaction
    {
        $this->pushURLFailure = $pushURLFailure;

        return $this;
    }

    /**
     * PushURLFailure getter.
     *
     * @return string
     */
    public function getPushURLFailure(): string
    {
        return $this->pushURLFailure;
    }

    /**
     * ClientUserAgent setter.
     *
     * @param string $clientUserAgent
     * @return Transaction
     */
    public function setClientUserAgent(string $clientUserAgent): Transaction
    {
        $this->clientUserAgent = $clientUserAgent;

        return $this;
    }

    /**
     * ClientUserAgent getter.
     *
     * @return string
     */
    public function getClientUserAgent(): string
    {
        return $this->clientUserAgent;
    }

    /**
     * OriginalTransactionReference setter.
     *
     * @param string $originalTransactionReference
     * @return Transaction
     */
    public function setOriginalTransactionReference(string $originalTransactionReference): Transaction
    {
        $this->originalTransactionReference = $originalTransactionReference;

        return $this;
    }

    /**
     * OriginalTransactionReference getter.
     *
     * @return string
     */
    public function getOriginalTransactionReference(): string
    {
        return $this->originalTransactionReference;
    }

    /**
     * CustomParameters setter.
     *
     * @param array $customParameters
     * @return Transaction
     */
    public function setCustomParameters(array $customParameters): Transaction
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * CustomParameters getter.
     *
     * @return array
     */
    public function getCustomParameters(): array
    {
        return $this->customParameters;
    }

    /**
     * AdditionalParameters setter.
     *
     * @param array $additionalParameters
     * @return Transaction
     */
    public function setAdditionalParameters(array $additionalParameters): Transaction
    {
        $this->additionalParameters = $additionalParameters;

        return $this;
    }

    /**
     * AdditionalParameters getter.
     *
     * @return array
     */
    public function getAdditionalParameters(): array
    {
        return $this->additionalParameters;
    }

    /**
     * Key setter.
     *
     * @param string $key
     * @return Transaction
     */
    public function setKey(string $key): Transaction
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Key getter.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Status setter.
     *
     * @param stdClass $status
     * @return Transaction
     */
    public function setStatus(stdClass $status): Transaction
    {
        $code = (new Code())->setCode($status->Code->Code)->setDescription($status->Code->Description);
        $subcode = (new Code())->setCode($status->SubCode->Code)->setDescription($status->SubCode->Description);
        $datetime = new DateTime($status->DateTime);

        $this->status = (new Status())->setCode($code)->setSubcode($subcode)->setDateTime($datetime);

        return $this;
    }

    /**
     * Status getter.
     *
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * RequiredAction setter.
     *
     * @param stdClass $requiredAction
     * @return Transaction
     */
    public function setRequiredAction(?stdClass $requiredAction): Transaction
    {
        $this->requiredAction = (new RequiredAction())
            ->setRedirectUrl($requiredAction->RedirectURL)
            ->setRequestedInformation($requiredAction->RequestedInformation)
            ->setPayRemainderDetails($requiredAction->PayRemainderDetails)
            ->setName($requiredAction->Name)
            ->setTypeDeprecated($requiredAction->TypeDeprecated);

        return $this;
    }

    /**
     * RequiredAction getter.
     *
     * @return RequiredAction
     */
    public function getRequiredAction(): RequiredAction
    {
        return $this->requiredAction;
    }

    /**
     * RequestErrors setter.
     *
     * @param string $requestErrors
     * @return Transaction
     */
    public function setRequestErrors(?string $requestErrors): Transaction
    {
        $this->requestErrors = $requestErrors;

        return $this;
    }

    /**
     * RequestErrors getter.
     *
     * @return string
     */
    public function getRequestErrors(): ?string
    {
        return $this->requestErrors;
    }

    /**
     * ServiceCode setter.
     *
     * @param string $serviceCode
     * @return Transaction
     */
    public function setServiceCode(string $serviceCode): Transaction
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * ServiceCode getter.
     *
     * @return string
     */
    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    /**
     * IsTest setter.
     *
     * @param bool $isTest
     * @return Transaction
     */
    public function setIsTest(bool $isTest): Transaction
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * IsTest getter.
     *
     * @return bool
     */
    public function getIsTest(): bool
    {
        return $this->isTest;
    }

    /**
     * TransactionType setter.
     *
     * @param string $transactionType
     * @return Transaction
     */
    public function setTransactionType(string $transactionType): Transaction
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * TransactionType getter.
     *
     * @return string
     */
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    /**
     * MutationType setter.
     *
     * @param int $mutationType
     * @return Transaction
     */
    public function setMutationType(int $mutationType): Transaction
    {
        $this->mutationType = $mutationType;

        return $this;
    }

    /**
     * MutationType getter.
     *
     * @return int
     */
    public function getMutationType(): int
    {
        return $this->mutationType;
    }

    /**
     * RelatedTransactions setter.
     *
     * @param array $relatedTransactions
     * @return Transaction
     */
    public function setRelatedTransactions(?array $relatedTransactions): Transaction
    {
        $this->relatedTransactions = $relatedTransactions;

        return $this;
    }

    /**
     * RelatedTransactions getter.
     *
     * @return array
     */
    public function getRelatedTransactions(): ?array
    {
        return $this->relatedTransactions;
    }

    /**
     * ConsumerMessage setter.
     *
     * @param string $consumerMessage
     * @return Transaction
     */
    public function setConsumerMessage(?string $consumerMessage): Transaction
    {
        $this->consumerMessage = $consumerMessage;

        return $this;
    }

    /**
     * ConsumerMessage getter.
     *
     * @return string
     */
    public function getConsumerMessage(): ?string
    {
        return $this->consumerMessage;
    }

    /**
     * Order setter.
     *
     * @param string $order
     * @return Transaction
     */
    public function setOrder(?string $order): Transaction
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Order getter.
     *
     * @return string
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * IssuingCountry setter.
     *
     * @param string $issuingCountry
     * @return Transaction
     */
    public function setIssuingCountry(?string $issuingCountry): Transaction
    {
        $this->issuingCountry = $issuingCountry;

        return $this;
    }

    /**
     * IssuingCountry getter.
     *
     * @return string
     */
    public function getIssuingCountry(): ?string
    {
        return $this->issuingCountry;
    }

    /**
     * Recurring setter.
     *
     * @param bool $recurring
     * @return Transaction
     */
    public function setRecurring(bool $recurring): Transaction
    {
        $this->recurring = $recurring;

        return $this;
    }

    /**
     * Recurring getter.
     *
     * @return bool
     */
    public function getRecurring(): bool
    {
        return $this->recurring;
    }

    /**
     * CustomerName setter.
     *
     * @param string $customerName
     * @return Transaction
     */
    public function setCustomerName(?string $customerName): Transaction
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * CustomerName getter.
     *
     * @return string
     */
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    /**
     * PayerHash setter.
     *
     * @param string $payerHash
     * @return Transaction
     */
    public function setPayerHash(?string $payerHash): Transaction
    {
        $this->payerHash = $payerHash;

        return $this;
    }

    /**
     * PayerHash getter.
     *
     * @return string
     */
    public function getPayerHash(): ?string
    {
        return $this->payerHash;
    }

    /**
     * PaymentKey setter.
     *
     * @param string $paymentKey
     * @return Transaction
     */
    public function setPaymentKey(string $paymentKey): Transaction
    {
        $this->paymentKey = $paymentKey;

        return $this;
    }

    /**
     * PaymentKey getter.
     *
     * @return string
     */
    public function getPaymentKey(): string
    {
        return $this->paymentKey;
    }

    /**
     * Execute transaction
     *
     * @return Transaction
     */
    public function execute(): Transaction
    {
        $response = json_decode($this->client->call($this->getData()));
        $this
            ->setServiceData($response->Services)
            ->setKey($response->Key)
            ->setStatus($response->Status)
            ->setRequiredAction($response->RequiredAction)
            ->setRequestErrors($response->RequestErrors)
            ->setServiceCode($response->ServiceCode)
            ->setIsTest($response->IsTest)
            ->setTransactionType($response->TransactionType)
            ->setMutationType($response->MutationType)
            ->setRelatedTransactions($response->RelatedTransactions)
            ->setConsumerMessage($response->ConsumerMessage)
            ->setOrder($response->Order)
            ->setIssuingCountry($response->IssuingCountry)
            ->setRecurring($response->Recurring)
            ->setCustomerName($response->CustomerName)
            ->setPayerHash($response->PayerHash)
            ->setPaymentKey($response->PaymentKey);

        return $this;
    }

    /**
     * ServiceData setter.
     *
     * @param array $services
     * @return Transaction
     */
    private function setServiceData(array $services): Transaction
    {
        foreach ($services as $service) {
            $this->getService($service->Name)->setParameters($service->Parameters);
        }

        return $this;
    }

    /**
     * Data getter.
     *
     * @return array
     */
    private function getData(): array
    {
        $data = [
            'Currency' => $this->getCurrency(),
            'Invoice' => $this->getInvoice(),
            'Service' => ['ServiceList' => []],
        ];
        foreach ($this->getServices() as $service) {
            $data['Service']['ServiceList'][] = $service->toArray();
            if ($service->getAction() === 'Pay') {
                $data['AmountDebit'] = $this->getAmount();
            } elseif ($service->getAction() === 'Refund') {
                $data['AmountCredit'] = $this->getAmount();
            }
        }
        return $data;
    }
}

