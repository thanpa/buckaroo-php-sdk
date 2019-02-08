<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information about the transaction reference.
 * Each transaction reference has a type and a reference.
 */
class TransactionReference
{

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $reference = '';

    /**
     * Type setter
     *
     * @param string $type
     * @return TransactionReference
     */
    public function setType(string $type): TransactionReference
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Type getter
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Reference setter
     *
     * @param string $reference
     * @return TransactionReference
     */
    public function setReference(string $reference): TransactionReference
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Reference getter
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}
