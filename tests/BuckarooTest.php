<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Buckaroo;

final class BuckarooTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeClientThrowsTypeError(): void
    {
        $buckaroo = new Buckaroo();
        $buckaroo->setClient('InvalidClient');
    }
}
