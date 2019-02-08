<?php
namespace Buckaroo;

/**
 * This interface is needed so that the mocked (phpUnit) client will
 * implement the same interface as the normal api client.
 */
interface ClientInterface
{
    public function call(): ClientInterface;
    public function getDecodedResponse(): \stdClass;
}
