<?php
namespace Buckaroo\Service;

/**
 * This class holds information about the response data of the API
 * that have to do with the ideal payment method actions (pay, refund).
 */
class Ideal extends ServiceAbstract implements ServiceInterface
{
    /**
     * @var string
     */
    protected $issuer = '';

    /**
     * @var string
     */
    protected $consumerIssuer = '';

    /**
     * @var string
     */
    protected $transactionId = '';

    /**
     * @var string
     */
    protected $customerAccountName = '';

    /**
     * @var string
     */
    protected $customerIban = '';

    /**
     * @var string
     */
    protected $customerBic = '';

    /**
     * Name getter
     *
     * @return string
     */
    public function getName(): string
    {
        return 'ideal';
    }

    /**
     * Issuer setter
     *
     * @param Issuer $issuer
     * @return Ideal
     */
    public function setIssuer(string $issuer): Ideal
    {
        $this->issuer = $issuer;

        return $this;
    }

    /**
     * Issuer getter
     *
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * ConsumerIssuer setter
     *
     * @param ConsumerIssuer $consumerIssuer
     * @return Ideal
     */
    public function setConsumerIssuer(string $consumerIssuer): Ideal
    {
        $this->consumerIssuer = $consumerIssuer;

        return $this;
    }

    /**
     * ConsumerIssuer getter
     *
     * @return string
     */
    public function getConsumerIssuer(): string
    {
        return $this->consumerIssuer;
    }

    /**
     * TransactionId setter
     *
     * @param TransactionId $transactionId
     * @return Ideal
     */
    public function setTransactionId(string $transactionId): Ideal
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * TransactionId getter
     *
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * CustomerAccountName setter
     *
     * @param CustomerAccountName $customerAccountName
     * @return Ideal
     */
    public function setCustomerAccountName(string $customerAccountName): Ideal
    {
        $this->customerAccountName = $customerAccountName;

        return $this;
    }

    /**
     * CustomerAccountName getter
     *
     * @return string
     */
    public function getCustomerAccountName(): string
    {
        return $this->customerAccountName;
    }

    /**
     * CustomerIban setter
     *
     * @param CustomerIban $customerIban
     * @return Ideal
     */
    public function setCustomerIban(string $customerIban): Ideal
    {
        $this->customerIban = $customerIban;

        return $this;
    }

    /**
     * CustomerIban getter
     *
     * @return string
     */
    public function getCustomerIban(): string
    {
        return $this->customerIban;
    }

    /**
     * CustomerBic setter
     *
     * @param CustomerBic $customerBic
     * @return Ideal
     */
    public function setCustomerBic(string $customerBic): Ideal
    {
        $this->customerBic = $customerBic;


        return $this;
    }

    /**
     * CustomerBic getter
     *
     * @return string
     */
    public function getCustomerBic(): string
    {
        return $this->customerBic;
    }

    /**
     * Parameter setter
     *
     * @param array $parameters
     * @return Ideal
     */
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

    /**
     * Transforms the ideal object to array
     *
     * @return array
     */
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