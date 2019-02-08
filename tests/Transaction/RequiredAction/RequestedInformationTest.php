<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\RequiredAction\RequestedInformation;

final class RequestedInformationTest extends TestCase
{
    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedDataTypeException
     */
    public function testSetInvalidDataTypeThrowsTypeUnsupportedRequestedInformationDataTypeException(): void
    {
        $requestedInformation = new RequestedInformation();
        $requestedInformation->setDataType(100);
    }
}

