<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information about the related transaction.
 */
class RelatedTransaction
{

    /**
     * @var string
     */
    private $relationType = '';

    /**
     * @var string
     */
    private $relatedTransactionKey = '';

    /**
     * RelationType setter.
     *
     * @param string $relationType
     * @return RelatedTransaction
     */
    public function setRelationType(string $relationType): RelatedTransaction
    {
        $this->relationType = $relationType;

        return $this;
    }

    /**
     * RelationType getter.
     *
     * @return string
     */
    public function getRelationType(): string
    {
        return $this->relationType;
    }

    /**
     * RelatedTransactionKey setter.
     *
     * @param string $relatedTransactionKey
     * @return RelatedTransaction
     */
    public function setRelatedTransactionKey(string $relatedTransactionKey): RelatedTransaction
    {
        $this->relatedTransactionKey = $relatedTransactionKey;

        return $this;
    }

    /**
     * RelatedTransactionKey getter.
     *
     * @return string
     */
    public function getRelatedTransactionKey(): string
    {
        return $this->relatedTransactionKey;
    }
}
