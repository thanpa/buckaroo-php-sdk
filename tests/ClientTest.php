<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Client;

final class ClientTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeWebsiteKeyThrowsTypeError(): void
    {
        $client = new Client();
        $client->setWebsiteKey(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeSecretKeyThrowsTypeError(): void
    {
        $client = new Client();
        $client->setSecretKey(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testInvalidTypeCallThrowsTypeError(): void
    {
        $client = new Client();
        $client->call('invalidData');
    }
}

