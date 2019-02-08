<?php
namespace Buckaroo\Service;

/**
 * This class holds information about the response data of the API
 * that have to do with the ideal payment method actions (pay, refund).
 */
class Ideal extends ServiceAbstract implements ServiceInterface
{
    const BANK_ABN_AMRO = 'ABNANL2A';
    const BANK_ASN = 'ASNBNL21';
    const BANK_ING = 'INGBNL2A';
    const BANK_RABOBANK = 'RABONL2U';
    const BANK_SNS = 'SNSBNL2A';
    const BANK_SNS_REGIO = 'RBRBNL21';
    const BANK_TRIODOS = 'TRIONL2U';
    const BANK_VAN = 'FVLBNL22';
    const BANK_KNAB = 'KNABNL2H';
    const BANK_BUNQ = 'BUNQNL2A';
    const BANK_MONEYOU = 'MOYONL21';
    const BANK_HANDELSBANKEN = 'HANDNL2A';
    const VALID_ISSUING_BANKS =
        [
            self::BANK_ABN_AMRO,
            self::BANK_ASN,
            self::BANK_ING,
            self::BANK_RABOBANK,
            self::BANK_SNS,
            self::BANK_SNS_REGIO,
            self::BANK_TRIODOS,
            self::BANK_VAN,
            self::BANK_KNAB,
            self::BANK_BUNQ,
            self::BANK_MONEYOU,
            self::BANK_HANDELSBANKEN
        ];

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
        return strtolower(basename(str_replace('\\', '/', get_class($this))));
    }

    /**
     * Issuer setter
     *
     * @param Issuer $issuer
     * @return Ideal
     */
    public function setIssuer(string $issuer): Ideal
    {
        $this->getValidator()->validateIssuer($issuer);
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
     * @param string $customerIban
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
     * @param string $customerBic
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
                    [
                        'Name' => 'issuer',
                        'Value' => $this->getIssuer(),
                    ],
                ],
            ];

    }
}