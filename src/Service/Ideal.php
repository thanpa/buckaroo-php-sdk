<?php
namespace Buckaroo\Service;

class Ideal extends ServiceAbstract implements ServiceInterface
{
    protected $issuer = '';

    protected $consumerIssuer = '';

    protected $transactionId = '';

    protected $customerAccountName = '';

    protected $customerIban = '';

    protected $customerBic = '';

    public function getName(): string
    {
        return 'ideal';
    }

    public function setIssuer(string $issuer): Ideal
    {
        $this->issuer = $issuer;

        return $this;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function setConsumerIssuer(string $consumerIssuer): Ideal
    {
        $this->consumerIssuer = $consumerIssuer;

        return $this;
    }

    public function getConsumerIssuer(): string
    {
        return $this->consumerIssuer;
    }

    public function setTransactionId(string $transactionId): Ideal
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setCustomerAccountName(string $customerAccountName): Ideal
    {
        $this->customerAccountName = $customerAccountName;

        return $this;
    }

    public function getCustomerAccountName(): string
    {
        return $this->customerAccountName;
    }

    public function setCustomerIban(string $customerIban): Ideal
    {
        $this->customerIban = $customerIban;

        return $this;
    }

    public function getCustomerIban(): string
    {
        return $this->customerIban;
    }

    public function setCustomerBic(string $customerBic): Ideal
    {
        $this->customerBic = $customerBic;

        return $this;
    }

    public function getCustomerBic(): string
    {
        return $this->customerBic;
    }

    public function setParameters(array $parameters): ServiceInterface
    {
        $parameters = array_combine(array_column($parameters, 'Name'), array_column($parameters, 'Value'));
        if (isset($parameters['consumerIssuer'])) {
            $this->consumerIssuer = $parameters['consumerIssuer'];
        }
        if (isset($parameters['transactionId'])) {
            $this->transactionId = $parameters['transactionId'];
        }
        if (isset($parameters['customeraccountname'])) {
            $this->customerAccountName = $parameters['customeraccountname'];
        }
        if (isset($parameters['CustomerIBAN'])) {
            $this->customerIban = $parameters['CustomerIBAN'];
        }
        if (isset($parameters['CustomerBIC'])) {
            $this->customerBic = $parameters['CustomerBIC'];
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'Name' => $this->getName(),
            'Action' => $this->getAction(),
            'Parameters' => [
                'Name' => 'issuer',
                'Value' => $this->getIssuer(),
            ],
        ];
    }
}