<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\Status\Code;

final class CodeTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeCodeThrowsTypeError(): void
    {
        $code = new Code();
        $code->setCode(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeDescriptionThrowsTypeError(): void
    {
        $code = new Code();
        $code->setDescription(new \stdClass());
    }
}

