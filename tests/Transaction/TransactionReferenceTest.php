<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\TransactionReference;

final class TransactionReferenceTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeTypeThrowsTypeError(): void
    {
        $transactionReference = new TransactionReference();
        $transactionReference->setType([]);
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeReferenceThrowsTypeError(): void
    {
        $transactionReference = new TransactionReference();
        $transactionReference->setReference([]);
    }
}

