<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Buckaroo;

final class BuckarooTest extends TestCase
{
    public function testSetsApiKeys(): void
    {
        $buckaroo = new Buckaroo();
        $buckaroo->setApiKeys('this-is-the-website-key', 'and-this-is-the-secret-key');
        $this->assertEquals('this-is-the-website-key', $buckaroo->getClient()->getWebsiteKey());
        $this->assertEquals('and-this-is-the-secret-key', $buckaroo->getClient()->getSecretKey());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeClientThrowsTypeError(): void
    {
        $buckaroo = new Buckaroo();
        $buckaroo->setClient('InvalidClient');
    }
}
