<?php
namespace Buckaroo\Service;

class Ideal extends ServiceAbstract implements ServiceInterface
{
    protected $issuer = '';

    protected $consumerIssuer = '';

    protected $transactionId = '';

    protected $customeraccountname = '';

    protected $CustomerIBAN = '';

    protected $CustomerBIC = '';

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

    public function setCustomerAccountName(string $customeraccountname): Ideal
    {
        $this->customeraccountname = $customeraccountname;

        return $this;
    }

    public function getCustomerAccountName(): string
    {
        return $this->customeraccountname;
    }

    public function setCustomerIban(string $CustomerIBAN): Ideal
    {
        $this->CustomerIBAN = $CustomerIBAN;

        return $this;
    }

    public function getCustomerIban(): string
    {
        return $this->CustomerIBAN;
    }

    public function setCustomerBic(string $CustomerBIC): Ideal
    {
        $this->CustomerBIC = $CustomerBIC;

        return $this;
    }

    public function getCustomerBic(): string
    {
        return $this->CustomerBIC;
    }
}