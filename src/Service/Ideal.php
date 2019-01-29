<?php
namespace Buckaroo\Service;

class Ideal extends ServiceAbstract implements ServiceInterface
{
    protected $issuer = '';

    protected $consumerIssuer = '';

    protected $transactionId = '';

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
}