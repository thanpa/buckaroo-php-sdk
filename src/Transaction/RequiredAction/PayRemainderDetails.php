<?php
namespace Buckaroo\Transaction\RequiredAction;

/**
 * This class holds information about the pay remainder details of the
 * required action of a trancaction
 */
class PayRemainderDetails
{

    /**
     * @var float
     */
    private $remainderAmount;

    /**
     * @var string
     */
    private $currency = '';

    /**
     * @var string
     */
    private $groupTransaction = '';

    /**
     * RemainderAmount setter
     *
     * @param float $remainderAmount
     * @return PayRemainderDetails
     */
    public function setRemainderAmount(float $remainderAmount): PayRemainderDetails
    {
        $this->remainderAmount = $remainderAmount;

        return $this;
    }

    /**
     * RemainderAmount getter
     *
     * @return float
     */
    public function getRemainderAmount(): float
    {
        return $this->remainderAmount;
    }

    /**
     * Currency setter
     *
     * @param string $currency
     * @return PayRemainderDetails
     */
    public function setCurrency(string $currency): PayRemainderDetails
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Currency getter
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * GroupTransaction setter
     *
     * @param string $groupTransaction
     * @return PayRemainderDetails
     */
    public function setGroupTransaction(string $groupTransaction): PayRemainderDetails
    {
        $this->groupTransaction = $groupTransaction;

        return $this;
    }

    /**
     * Currency getter
     *
     * @return string
     */
    public function getGroupTransaction(): string
    {
        return $this->groupTransaction;
    }
}
