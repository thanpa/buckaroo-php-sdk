<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\Status;

final class StatusTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCodeThrowsTypeError(): void
    {
        $status = new Status();
        $status->setCode(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeSubcodeThrowsTypeError(): void
    {
        $status = new Status();
        $status->setSubcode(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeDatetimeThrowsTypeError(): void
    {
        $status = new Status();
        $status->setDatetime(new \stdClass());
    }
}

