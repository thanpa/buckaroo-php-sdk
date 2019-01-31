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

class Transaction
{
    private $currency = '';
    private $amount = 0;
    private $invoice = '';
    private $description = '';
    private $clientIp;
    private $returnUrl = '';
    private $returnUrlCancel = '';
    private $returnUrlError = '';
    private $returnUrlReject = '';
    private $originalTransactionKey = '';
    private $startRecurrent = false;
    private $continueOnIncomplete = 'No';
    private $services = [];
    private $servicesSelectableByClient = '';
    private $servicesExcludedForClient = '';
    private $pushURL = '';
    private $pushURLFailure = '';
    private $clientUserAgent = '';
    private $originalTransactionReference = '';
    private $customParameters = [];
    private $additionalParameters = [];

    private $key = '';
    private $status;
    private $requiredAction;

    private $requestErrors = null;
    private $serviceCode = '';
    private $isTest = true;
    private $transactionType = '';
    private $mutationType = 1;
    private $relatedTransactions = null;
    private $consumerMessage = null;
    private $order = null;
    private $issuingCountry = null;
    private $recurring = false;
    private $customerName = null;
    private $payerHash = null;
    private $paymentKey = '';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function setClient(ClientInterface $client): Transaction
    {
        $this->client = $client;

        return $this;
    }

    public function setCurrency(string $currency): Transaction
    {
        // Filter valid currency
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setInvoice(string $invoice): Transaction
    {
        // Filter printable characters
        $this->invoice = $invoice;

        return $this;
    }

    public function getInvoice(): string
    {
        return $this->invoice;
    }

    public function setDescription(string $description): Transaction
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getClientIp(): ClientIp
    {
        return $this->clientIp;
    }

    public function setClientIp(ClientIp $clientIp): Transaction
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function setReturnUrl(string $returnUrl): Transaction
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    public function getReturnUrlCancel(): string
    {
        return $this->returnUrlCancel;
    }

    public function setReturnUrlCancel(string $returnUrlCancel): Transaction
    {
        $this->returnUrlCancel = $returnUrlCancel;

        return $this;
    }

    public function getReturnUrlError(): string
    {
        return $this->returnUrlError;
    }

    public function setReturnUrlError(string $returnUrlError): Transaction
    {
        $this->returnUrlError = $returnUrlError;

        return $this;
    }

    public function getReturnUrlReject(): string
    {
        return $this->returnUrlReject;
    }

    public function setReturnUrlReject(string $returnUrlReject): Transaction
    {
        $this->returnUrlReject = $returnUrlReject;

        return $this;
    }

    public function getOriginalTransactionKey(): string
    {
        return $this->originalTransactionKey;
    }

    public function setOriginalTransactionKey(string $originalTransactionKey): Transaction
    {
        $this->originalTransactionKey = $originalTransactionKey;

        return $this;
    }

    public function getStartRecurrent(): bool
    {
        return $this->startRecurrent;
    }

    public function setStartRecurrent(bool $startRecurrent): Transaction
    {
        $this->startRecurrent = $startRecurrent;

        return $this;
    }

    public function getContinueOnIncomplete(): string
    {
        return $this->continueOnIncomplete;
    }

    public function setContinueOnIncomplete(string $continueOnIncomplete): Transaction
    {
        $this->continueOnIncomplete = $continueOnIncomplete;

        return $this;
    }

    public function addService(ServiceInterface $service): Transaction
    {
        $this->services[$service->getName()] = $service;

        return $this;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function getService(string $name): ServiceInterface
    {
        return $this->services[$name];
    }

    public function getServicesSelectableByClient(): string
    {
        return $this->servicesSelectableByClient;
    }

    public function setServicesSelectableByClient(string $servicesSelectableByClient): Transaction
    {
        $this->servicesSelectableByClient = $servicesSelectableByClient;

        return $this;
    }

    public function getServicesExcludedForClient(): string
    {
        return $this->servicesExcludedForClient;
    }

    public function setServicesExcludedForClient(string $servicesExcludedForClient): Transaction
    {
        $this->servicesExcludedForClient = $servicesExcludedForClient;

        return $this;
    }

    public function getPushURL(): string
    {
        return $this->pushURL;
    }

    public function setPushURL(string $pushURL): Transaction
    {
        $this->pushURL = $pushURL;

        return $this;
    }

    public function getPushURLFailure(): string
    {
        return $this->pushURLFailure;
    }

    public function setPushURLFailure(string $pushURLFailure): Transaction
    {
        $this->pushURLFailure = $pushURLFailure;

        return $this;
    }

    public function getClientUserAgent(): string
    {
        return $this->clientUserAgent;
    }

    public function setClientUserAgent(string $clientUserAgent): Transaction
    {
        $this->clientUserAgent = $clientUserAgent;

        return $this;
    }

    public function getOriginalTransactionReference(): string
    {
        return $this->originalTransactionReference;
    }

    public function setOriginalTransactionReference(string $originalTransactionReference): Transaction
    {
        $this->originalTransactionReference = $originalTransactionReference;

        return $this;
    }

    public function getCustomParameters(): array
    {
        return $this->customParameters;
    }

    public function setCustomParameters(array $customParameters): Transaction
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    public function getAdditionalParameters(): array
    {
        return $this->additionalParameters;
    }

    public function setAdditionalParameters(array $additionalParameters): Transaction
    {
        $this->additionalParameters = $additionalParameters;

        return $this;
    }

    public function setKey(string $key): Transaction
    {
        $this->key = $key;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setStatus(stdClass $status): Transaction
    {
        $code = (new Code())->setCode($status->Code->Code)->setDescription($status->Code->Description);
        $subcode = (new Code())->setCode($status->SubCode->Code)->setDescription($status->SubCode->Description);
        $datetime = new DateTime($status->DateTime);

        $this->status = (new Status())->setCode($code)->setSubcode($subcode)->setDateTime($datetime);

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

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

    public function getRequiredAction(): RequiredAction
    {
        return $this->requiredAction;
    }

    public function setRequestErrors(?string $requestErrors): Transaction
    {
        $this->requestErrors = $requestErrors;

        return $this;
    }

    public function getRequestErrors(): ?string
    {
        return $this->requestErrors;
    }

    public function setServiceCode(string $serviceCode): Transaction
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    public function setIsTest(bool $isTest): Transaction
    {
        $this->isTest = $isTest;

        return $this;
    }

    public function getIsTest(): bool
    {
        return $this->isTest;
    }

    public function setTransactionType(string $transactionType): Transaction
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function setMutationType(int $mutationType): Transaction
    {
        $this->mutationType = $mutationType;

        return $this;
    }

    public function getMutationType(): int
    {
        return $this->mutationType;
    }

    public function setRelatedTransactions(?array $relatedTransactions): Transaction
    {
        $this->relatedTransactions = $relatedTransactions;

        return $this;
    }

    public function getRelatedTransactions(): ?array
    {
        return $this->relatedTransactions;
    }

    public function setConsumerMessage(?string $consumerMessage): Transaction
    {
        $this->consumerMessage = $consumerMessage;

        return $this;
    }

    public function getConsumerMessage(): ?string
    {
        return $this->consumerMessage;
    }

    public function setOrder(?string $order): Transaction
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setIssuingCountry(?string $issuingCountry): Transaction
    {
        $this->issuingCountry = $issuingCountry;

        return $this;
    }

    public function getIssuingCountry(): ?string
    {
        return $this->issuingCountry;
    }

    public function setRecurring(bool $recurring): Transaction
    {
        $this->recurring = $recurring;

        return $this;
    }

    public function getRecurring(): bool
    {
        return $this->recurring;
    }

    public function setCustomerName(?string $customerName): Transaction
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setPayerHash(?string $payerHash): Transaction
    {
        $this->payerHash = $payerHash;

        return $this;
    }

    public function getPayerHash(): ?string
    {
        return $this->payerHash;
    }

    public function setPaymentKey(string $paymentKey): Transaction
    {
        $this->paymentKey = $paymentKey;

        return $this;
    }

    public function getPaymentKey(): string
    {
        return $this->paymentKey;
    }

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

    private function setServiceData(array $services): Transaction
    {
        foreach ($services as $service) {
            $this->getService($service->Name)->setParameters($service->Parameters);
        }

        return $this;
    }

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

